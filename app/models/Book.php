<?php

namespace App\Models;

class Book extends \Core\Model
{
    /** @var string|null */
    protected $title;

    /** @var string|null */
    protected $publicated_at;

    /** @var string|null */
    protected $resume;

    /** @var string|null */
    protected $isbn;

    /** @var string|null */
    protected $cover;

    /** @var int|null */
    protected $author_id;

    /** @var int|null */
    protected $category_id;

    /** @var Author|false|null */
    protected $author;

    /** @var Category|false|null */
    protected $category;

    /** @var float|string|false|null */
    protected $notation;

    /** @var Tag[]|null */
    protected $tags;



    
    protected function setNotation()
    {
        $this->notation = BooksManager::findNotationByBookId($this->id);
    }
    protected function setTags()
    {
        $this->tags = TagsManager::findAllByBookId($this->id);
    }
}
