<?php

namespace App\Models;

class Tag extends \Core\Model
{
    /** @var string|null */
    protected $name;

    /** @var Book[]|null */
    protected $books;

    protected function setBooks(): void
    {
        $this->books = BooksManager::findAllByTagId($this->id);
    }
}
