<?php

use \App\Controllers\TagsController;

switch($_GET['tags']):

    case 'show':

        TagsController::showAction($_GET['id']);
        
        break;


    default:

    TagsController::indexAction();

    break;
endswitch;