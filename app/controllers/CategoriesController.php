<?php

namespace App\Controllers;

abstract class CategoriesController extends \Core\Controller
{
    protected static $table = 'categories';
    protected static $Manager = \App\Models\CategoriesManager::class;
}
