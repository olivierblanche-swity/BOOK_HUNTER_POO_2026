<?php

use \App\Controllers\CategoriesController;

switch($_GET['categories']):

    case 'show':

        CategoriesController::showAction($_GET['id']);
        
        break;


    default:

    CategoriesController::indexAction();

    break;
endswitch;