<?php

namespace App\Controllers; 






abstract class AuthorsController extends \Core\Controller {

protected static $table = 'authors';
protected static $Manager = \App\Models\AuthorsManager::class;




}