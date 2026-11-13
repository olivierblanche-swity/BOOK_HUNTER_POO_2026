<?php

namespace App\Models;

class Book extends \Core\Model
{
    protected $id, $title, $created_at, $publicated_at, $resume, $isbn, $cover, $author_id, $category_id;

    protected $author, $notation, $tags;

    
    protected function setAuthor()
    {
        $this->author = AuthorsManager::findOneById($this->author_id);
    }
    protected function setNotation()
    {
        $this->notation = BooksManager::findNotationByBookId($this->id);
    }
    protected function setTags()
    {
        $this->tags = TagsManager::findAllByBookId($this->id);
    }
}
