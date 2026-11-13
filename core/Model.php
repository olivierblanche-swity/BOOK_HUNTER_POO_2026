<?php

namespace Core;

abstract class Model {

public function __get(string $property)
    {
        if (property_exists($this, $property)):
        $methodName = 'set' . ucFirst($property);
        if (method_exists($this, $methodName)):
            $this->$methodName();
        endif;
        return $this->$property;
    endif;
    }
}