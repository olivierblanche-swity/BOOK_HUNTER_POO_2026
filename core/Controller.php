<?php
namespace Core;

/** Actions communes : récupère les objets via un manager puis charge leur vue. */
abstract class Controller 
{
    // Les classes filles indiquent le dossier des vues et le nom complet du manager.
    protected static $table;
    protected static $Manager;
    
public static function indexAction(int $limit = 10):void
{
    

    // static:: utilise la configuration du contrôleur appelé (BooksController, etc.).
    // Variable variable : si $table vaut 'books', le résultat est placé dans $books.
    ${static::$table} = static::$Manager::findAll($limit);

    
    // Le fichier inclus a accès aux variables locales de cette action.
    include __DIR__ . '/../app/views/'. static::$table .'/index.php';
}

public static function showAction(int $id):void
{
    

    // Détermine le nom de la variable au singulier pour la vue :
    // le ternaire (? :) transforme 'categories' en 'category' ; sinon,
    // substr(..., 0, -1) retire le dernier caractère ('books' → 'book', 'tags' → 'tag').
    $variable = static::$table === 'categories' ? 'category' : substr(static::$table, 0, -1);
    // Crée par exemple $book ou $category, le nom attendu dans la vue show.php.
    ${$variable} = static::$Manager::findOneById($id);

    
    include __DIR__ . '/../app/views/' .static::$table. '/show.php';
}

}

