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

    
    include '../app/views/'. static::$table .'/index.php';
}

public static function showAction(int $id):void
{
    

    ${substr(static::$table, 0,-1)} = static::$Manager::findOneById($id);

    
    include '../app/views/' .static::$table. '/show.php';
}

}

