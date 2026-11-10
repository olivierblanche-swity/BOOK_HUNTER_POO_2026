<?php

namespace App\Controllers\PagesController; 

use \PDO;
use \App\Models\BooksModel;
use \App\Models\AuthorsModel;

function indexAction(PDO $conn)
{
    include_once '../app/models/postsModel.php';
    
    global $title, $content;
    $title = "Accueil";
    ob_start();
    include '../app/views/pages/index.php';
    $content = ob_get_clean();
}
