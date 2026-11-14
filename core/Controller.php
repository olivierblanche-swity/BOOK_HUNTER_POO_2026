<?php
/** 
 * @var  $table
 *
 */

namespace Core;

abstract class Controller 
{
    protected static $table;
    protected static $Manager;
    
public static function indexAction(int $limit = 10):void
{
    

    ${static::$table} = static::$Manager::findAll($limit);

    
    include __DIR__ . '/../app/views/'. static::$table .'/index.php';
}

public static function showAction(int $id):void
{
    

    // Détermine le nom de la variable au singulier pour la vue :
    // le ternaire (? :) transforme 'categories' en 'category' ; sinon,
    // substr(..., 0, -1) retire le dernier caractère ('books' → 'book', 'tags' → 'tag').
    $variable = static::$table === 'categories' ? 'category' : substr(static::$table, 0, -1);
    ${$variable} = static::$Manager::findOneById($id);

    
    include __DIR__ . '/../app/views/' .static::$table. '/show.php';
}

}

