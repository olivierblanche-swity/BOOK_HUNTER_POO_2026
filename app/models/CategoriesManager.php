<?php

namespace App\Models;

abstract class CategoriesManager extends \Core\Manager
{
    protected static $table = 'categories';

    protected static $model = Category::class;
}
