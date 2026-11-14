<?php

namespace Core;

/** Base des objets métier : propriétés communes et chargement des relations à la demande. */
abstract class Model
{
    // protected permet aux modèles enfants d'utiliser ces propriétés héritées.
    protected $id, $created_at;

    // PHP appelle __get lorsqu'une propriété inaccessible est lue depuis l'extérieur.
    // Les relations doivent être déclarées protected dans les modèles enfants.
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            // Une valeur déjà chargée est réutilisée, y compris un tableau vide.
            // Si le chargement renvoie null, une prochaine lecture fera une nouvelle tentative.
            if ($this->$property === null) {
                $methodName = 'set' . ucfirst($property);
                // Les setters spécifiques (tags, notation, books) passent avant la convention.
                if (method_exists($this, $methodName)) {
                    $this->$methodName();
                } else {
                    // Convention : author → author_id → AuthorsManager.
                    // Category a un pluriel particulier : CategoriesManager.
                    $foreignKey = $property . '_id';
                    $plural = $property === 'category' ? 'categories' : $property . 's';
                    $manager = '\\App\\Models\\' . ucfirst($plural) . 'Manager';

                    // Charge une relation simple seulement si sa clé et son manager existent.
                    if (property_exists($this, $foreignKey) && class_exists($manager)) {
                        $this->$property = $manager::findOneById($this->$foreignKey);
                    }
                }
            }

            return $this->$property;
        }
        // Une propriété non déclarée donne implicitement null.
    }
}
