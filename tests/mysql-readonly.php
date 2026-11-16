<?php
// Mesure réelle, sans écriture SQL ni affichage des données du catalogue.
require __DIR__ . '/../vendor/autoload.php';
$_SERVER['SCRIPT_NAME'] = '/scripts/BES/framework serveur/BOOK_HUNTER_POO_2026/public/index.php';
$_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];
$_SERVER['REQUEST_SCHEME'] = 'http';
$_SERVER['HTTP_HOST'] = 'localhost';
\Core\App::start();

class CountedStatement extends PDOStatement {
    public static int $count = 0;
    protected function __construct() {}
    public function execute(?array $params = null): bool {
        self::$count++;
        return parent::execute($params);
    }
}
$db = \Core\DB::getConnexion();
$db->setAttribute(PDO::ATTR_STATEMENT_CLASS, [CountedStatement::class]);
set_error_handler(static function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
echo 'Encodage connexion : ', $db->query('SELECT @@character_set_connection')->fetchColumn(), PHP_EOL;
echo 'Collations : ', json_encode($db->query('SELECT DISTINCT TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE()')->fetchAll(PDO::FETCH_COLUMN)), PHP_EOL;
$paths = ['', 'books.html', 'authors.html'];
foreach (['books', 'authors', 'categories', 'tags'] as $table) {
    $id = $db->query('SELECT MIN(id) FROM ' . $table)->fetchColumn();
    if ($id !== null) { $paths[] = $table . '/' . $id . '/test.html'; }
}
foreach ($paths as $index => $path) {
    CountedStatement::$count = 0;
    $_SERVER['REQUEST_URI'] = rawurlencode(BASE_PATH) . '/' . $path;
    // rawurlencode encode aussi les séparateurs, décodés par le routeur.
    ob_start();
    if ($index === 0) {
        require __DIR__ . '/../app/routers/index.php';
    } else {
        \Core\Route::dispatch();
    }
    require __DIR__ . '/../app/views/templates/default.php';
    $html = ob_get_clean();
    echo ($path === '' ? 'Accueil' : strtok($path, '/')), ' : ', CountedStatement::$count, ' requêtes, ', strlen($html), ' octets HTML', PHP_EOL;
}
foreach (['Books', 'Authors', 'Categories', 'Tags'] as $name) {
    $manager = '\\App\\Models\\' . $name . 'Manager';
    $columns = (new ReflectionClass($manager))->getConstant('SORTABLE_COLUMNS');
    foreach ($columns as $column) { $manager::findAll(1, $column, 'ASC'); }
}
echo "Toutes les colonnes de tri déclarées sont acceptées par MySQL.\n";
restore_error_handler();
// Aucun secret ni contenu de ligne n’est affiché.
