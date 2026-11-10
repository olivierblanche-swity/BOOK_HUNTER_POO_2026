<?php

 /**
      * 1  route par defaut
      * PATTERN: /
      * CTRL:postsController
      * ACTION: index
      * 
      */

     include_once '../app/controllers/pagesController.php';
     \App\Controllers\PagesController\indexAction($conn);