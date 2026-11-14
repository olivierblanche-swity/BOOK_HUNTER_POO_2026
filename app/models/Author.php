<?php

namespace App\Models;

class Author extends \Core\Model
{

protected $id, $firstname, $lastname, $biography, $picture, $created_at;

protected $books, $notation;

protected function setNotation()
{
    $this->notation = AuthorsManager::findNotationByAuthorId($this->id);
}

protected function setBooks () {
    $this->books = BooksManager::findAllByAuthorId($this->id);
}
}
