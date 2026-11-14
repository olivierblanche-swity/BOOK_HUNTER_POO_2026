<?php

namespace App\Models;

class Category extends \Core\Model
{
    protected $name;

    protected $books;

    protected function setBooks(): void
    {
        $this->books = BooksManager::findAllByCategoryId($this->id);
    }
}
