<?php

// Tests isolés : aucune connexion MySQL, aucune configuration privée chargée.
namespace Core {
    class DB {
        public static array $queries = [];
        public static function getConnexion(): object {
            return new class {
                public function prepare(string $sql): object {
                    DB::$queries[] = $sql;
                    return new class {
                        public function bindValue(...$args): void {}
                        public function execute(): void {}
                        public function fetchAll(...$args): array { return []; }
                    };
                }
            };
        }
    }
}

namespace App\Models {
    class StoriesManager {
        public static function findOneById($id): string {
            return 'story ' . $id;
        }
    }
}

namespace {
    require __DIR__ . '/../core/Helpers.php';
    require __DIR__ . '/../core/Inflect.php';
    require __DIR__ . '/../core/Manager.php';
    require __DIR__ . '/../core/Model.php';
    foreach (['Books', 'Authors', 'Categories', 'Tags'] as $name) {
        require __DIR__ . '/../app/models/' . $name . 'Manager.php';
    }
    class StoryRelationModel extends \Core\Model {
        protected $story;
        protected $story_id = 42;
    }

    $checks = 0;
    function check(bool $condition): void {
        global $checks;
        if (!$condition) { throw new \RuntimeException('Échec du contrôle ' . ($checks + 1)); }
        $checks++;
    }
    check(\Core\Helpers::truncate('abcdefgh', 4) === 'abcd...');
    check(\Core\Helpers::truncate('étéàô', 4) === 'étéà...');
    check(\Core\Helpers::truncate('bonjour monde', 10) === 'bonjour...');
    check(\Core\Helpers::truncate('été', 3) === 'été');
    check(\Core\Helpers::truncate('abc', 0) === '');
    check(\Core\Helpers::dateFormator(null) === 'Date non renseignée');
    check(\Core\Helpers::dateFormator('  ') === 'Date non renseignée');
    check(\Core\Helpers::dateFormator('date-invalide') === 'Date invalide');
    check(\Core\Helpers::dateFormator('2026-02-30') === 'Date invalide');
    check(\Core\Helpers::dateFormator('2026-11-16', 'd/m/Y') === '16/11/2026');
    check((new StoryRelationModel())->story === 'story 42');
    foreach ([1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'] as $month => $name) {
        check(\Core\Helpers::dateFormator(sprintf('2026-%02d-01', $month)) === '1 ' . $name . ' 2026');
    }
    check(\Core\Helpers::dateFormator('2026-11-16') === '16 novembre 2026');
    foreach (['Books' => 'title', 'Authors' => 'lastname', 'Categories' => 'name', 'Tags' => 'name'] as $name => $column) {
        $manager = '\\App\\Models\\' . $name . 'Manager';
        $manager::findAll(null, $column, 'asc');
        check(str_contains(end(\Core\DB::$queries), 'ORDER BY `' . $column . '` ASC'));
        $manager::findAll();
        check(str_contains(end(\Core\DB::$queries), 'ORDER BY `created_at` DESC'));
        foreach (['books', 'author', 'notation', 'name; DROP TABLE books'] as $invalid) {
            $before = count(\Core\DB::$queries);
            try {
                $manager::findAll(null, $invalid);
                throw new \RuntimeException('Tri invalide accepté');
            } catch (\InvalidArgumentException $e) {
                check(count(\Core\DB::$queries) === $before);
            }
        }
    }
    echo $checks . " contrôles réussis\n";
}
