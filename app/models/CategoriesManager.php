<?php

namespace App\Models;

abstract class CategoriesManager extends \Core\Manager
{
    protected const SORTABLE_COLUMNS = ['id', 'created_at', 'name'];
}
