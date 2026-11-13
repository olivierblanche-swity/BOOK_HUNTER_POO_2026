<?php

namespace App\Controllers; 


use \App\Models\BooksManager;



class BooksController {

public function indexAction():void
{
    

    $books = BooksManager::findAll(9);

    
    global $title, $content;
    $title = "Latest Books & Authors";
    ob_start();
    include '../app/views/pages/home.php';
    $content = ob_get_clean();
}

}