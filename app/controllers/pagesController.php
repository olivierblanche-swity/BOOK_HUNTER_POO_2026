<?php

namespace App\Controllers; 

use \PDO;
use \App\Models\BooksModel;



class PagesController {

public function homeAction(PDO $conn):void
{
    include_once '../app/models/booksModel.php';

    $books = BooksModel\findAll($conn, 3);

    
    global $title, $content;
    $title = "Latest Books & Authors";
    ob_start();
    include '../app/views/pages/home.php';
    $content = ob_get_clean();
}

}

