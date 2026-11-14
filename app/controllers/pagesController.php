<?php

namespace App\Controllers;

use App\Models\AuthorsManager;

use \App\Models\BooksManager;




abstract class PagesController extends \Core\Controller {

public static function homeAction():void
{
    $books = BooksManager::findAllPopulars(3);
    $authors = AuthorsManager::findAllPopulars(3);

    
    // La vue définit ses sections title et content, comme les autres pages.
    include __DIR__ . '/../views/pages/home.php';
}

}

