<?php

namespace Core;

/** Actions communes : récupère les objets via un manager puis charge leur vue. */
abstract class Controller
{
    /** Déduit les noms depuis le contrôleur appelé, sans état statique partagé. */
    private static function init(): array
    {
        // static::class conserve le nom de la classe fille, par exemple BooksController.
        $class = basename(str_replace('\\', '/', static::class));
        $name = substr($class, 0, -strlen('Controller'));
        $table = strtolower($name);

        // Ne retire que le s final ; categories a un singulier particulier.
        $singular = $table === 'categories'
            ? 'category'
            : (str_ends_with($table, 's') ? substr($table, 0, -1) : $table);
        $manager = '\\App\\Models\\' . $name . 'Manager';

        return [$table, $singular, $manager];
    }

    public static function indexAction(int $limit = 10): void
    {
        // L'appel reste autorisé ici car init() et les actions appartiennent à la même classe.
        [$table, $singular, $manager] = static::init();

        // Variable variable : 'books' crée $books, le nom attendu dans la vue.
        ${$table} = $manager::findAll($limit);

        // Le fichier inclus a accès aux variables locales de cette action.
        include __DIR__ . '/../app/views/' . $table . '/index.php';
    }

    public static function showAction(int $id): void
    {
        [$table, $singular, $manager] = static::init();

        // Crée $book, $author, $category ou $tag selon le contrôleur appelé.
        ${$singular} = $manager::findOneById($id);

        include __DIR__ . '/../app/views/' . $table . '/show.php';
    }
}
