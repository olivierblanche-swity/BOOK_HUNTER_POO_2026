<?php

namespace Root;

use \App\Controllers;


// ROUTE DES BOOKS

if (isset($_GET['books'])):

    include_once '../app/routers/books.php';

// ROUTE DES AUTHORS

elseif (isset($_GET['authors'])):

    include_once '../app/routers/authors.php';

else :
//ROUTE HOMEPAGE

Controllers\PagesController::homeAction();

endif;
