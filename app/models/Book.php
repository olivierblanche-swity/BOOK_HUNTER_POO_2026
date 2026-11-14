<?php

namespace App\Models;

class Book extends \Core\Model
{
    protected $title, $publicated_at, $resume, $isbn, $cover, $author_id, $category_id;

    protected $author, $category, $notation, $tags;

    
    protected function setNotation()
    {
        $this->notation = BooksManager::findNotationByBookId($this->id);
    }
    protected function setTags()
    {
        $this->tags = TagsManager::findAllByBookId($this->id);
    }
}
