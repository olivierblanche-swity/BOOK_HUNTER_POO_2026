<?php

namespace App\Controllers;

abstract class TagsController extends \Core\Controller
{
    protected static $table = 'tags';
    protected static $Manager = \App\Models\TagsManager::class;
}
