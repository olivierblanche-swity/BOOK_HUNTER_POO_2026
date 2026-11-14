<?php

namespace Root;

use \App\Controllers;

// ROUTE DES CATEGORIES

if (isset($_GET['categories'])):

    include_once __DIR__ . '/categories.php';

//ROUTE DES TAGS

elseif (isset($_GET['tags'])):

    include_once __DIR__ . '/tags.php';

// ROUTE DES BOOKS

elseif (isset($_GET['books'])):

    include_once __DIR__ . '/books.php';

// ROUTE DES AUTHORS

elseif (isset($_GET['authors'])):

    include_once __DIR__ . '/authors.php';

else :
    
//ROUTE HOMEPAGE

Controllers\PagesController::homeAction();

endif;
