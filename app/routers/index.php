<?php

use Core\Route;
use App\Controllers\PagesController;
use App\Controllers\BooksController;
use App\Controllers\AuthorsController;
use App\Controllers\CategoriesController;
use App\Controllers\TagsController;

// Accueil : conserve aussi le lien index.html de la navigation.
Route::add('#^(?:index\.html|index\.php)?$#', PagesController::class, 'homeAction');

// Listes : conserve la limite actuelle de six éléments.
Route::add('#^books\.html$#', BooksController::class, 'indexAction', [6]);
Route::add('#^authors\.html$#', AuthorsController::class, 'indexAction', [6]);

// Détails : seul l'identifiant est capturé.
Route::add(
    '#^books/([1-9][0-9]*)/[0-9a-z](?:[a-z0-9\-]*[0-9a-z])*\.html$#',
    BooksController::class,
    'showAction'
);
Route::add(
    '#^authors/([1-9][0-9]*)/[0-9a-z](?:[a-z0-9\-]*[0-9a-z])*\.html$#',
    AuthorsController::class,
    'showAction'
);
Route::add(
    '#^categories/([1-9][0-9]*)/[0-9a-z](?:[a-z0-9\-]*[0-9a-z])*\.html$#',
    CategoriesController::class,
    'showAction'
);
Route::add(
    '#^tags/([1-9][0-9]*)/[0-9a-z](?:[a-z0-9\-]*[0-9a-z])*\.html$#',
    TagsController::class,
    'showAction'
);

// Dernière route : toute URL non reconnue affiche la page 404.
Route::add('#^.*$#s', PagesController::class, 'notFoundAction');

Route::dispatch();
