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
    
public static function indexAction():void
{
    

    ${static::$table} = static::$Manager::findAll();

    
    global $title, $content;
    
    ob_start();
    include '../app/views/'. static::$table .'/index.php';
    $content = ob_get_clean();
}

public static function showAction(int $id):void
{
    

    ${substr(static::$table, 0,-1)} = static::$Manager::findOneById($id);

    
    global $title, $content;

    ob_start();
    include '../app/views/' .static::$table. '/show.php';
    $content = ob_get_clean();
}

}

