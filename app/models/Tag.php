<?php

namespace App\Models;

class Tag extends \Core\Model
{
    protected $name;

    protected $books;

    protected function setBooks(): void
    {
        $this->books = BooksManager::findAllByTagId($this->id);
    }
}
