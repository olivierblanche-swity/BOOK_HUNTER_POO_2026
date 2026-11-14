<?php

namespace App\Controllers; 






abstract class BooksController extends \Core\Controller {

protected static $table = 'books';
protected static $Manager = \App\Models\BooksManager::class;





}