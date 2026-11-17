<?php

namespace App\Models;

class Author extends \Core\Model
{

    /** @var string|null */
    protected $firstname;

    /** @var string|null */
    protected $lastname;

    /** @var string|null */
    protected $biography;

    /** @var string|null */
    protected $picture;

    /** @var Book[]|null */
    protected $books;

    /** @var float|string|false|null */
    protected $notation;

protected function setNotation()
{
    $this->notation = AuthorsManager::findNotationByAuthorId($this->id);
}

protected function setBooks () {
    $this->books = BooksManager::findAllByAuthorId($this->id);
}
}
