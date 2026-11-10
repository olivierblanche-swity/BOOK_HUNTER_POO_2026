<?php

/**
      * 1  route par defaut
      * PATTERN: /
      * CTRL:pagesController
      * ACTION: index
      * 
      */

     include_once '../app/controllers/pagesController.php';
     \App\Controllers\PagesController\homeAction($conn);