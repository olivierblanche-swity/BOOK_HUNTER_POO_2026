<?php

namespace Core;

abstract class Model
{
    protected $id, $created_at;

    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            if ($this->$property === null) {
                $methodName = 'set' . ucfirst($property);
                if (method_exists($this, $methodName)) {
                    $this->$methodName();
                } else {
                    // Convention : author → author_id → AuthorsManager.
                    // Category a un pluriel particulier : CategoriesManager.
                    $foreignKey = $property . '_id';
                    $plural = $property === 'category' ? 'categories' : $property . 's';
                    $manager = '\\App\\Models\\' . ucfirst($plural) . 'Manager';

                    if (property_exists($this, $foreignKey) && class_exists($manager)) {
                        $this->$property = $manager::findOneById($this->$foreignKey);
                    }
                }
            }

            return $this->$property;
        }
    }
}
