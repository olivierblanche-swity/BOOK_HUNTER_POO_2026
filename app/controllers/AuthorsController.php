<?php

namespace App\Controllers; 


use \App\Models\AuthorsManager;



abstract class AuthorsController {

public static function indexAction():void
{
    

    $authors = AuthorsManager::findAll(9);

    
    global $title, $content;
    $title = "Recent Authors";
    ob_start();
    include '../app/views/authors/index.php';
    $content = ob_get_clean();
}

public static function showAction(int $id):void
{
    

    $author = AuthorsManager::findOneById($id);

    
    global $title, $content;
    $title = $author->title;
    ob_start();
    include '../app/views/authors/show.php';
    $content = ob_get_clean();
}
}