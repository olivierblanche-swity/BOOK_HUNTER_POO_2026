<?php

namespace App\Models;

class Author extends \Core\Model
{

protected $id, $firstname, $lastname, $biography, $picture, $created_at;

protected $books;

protected function setBooks () {
    $this->books = BooksManager::findAllByAuthorId($this->id);
}
}