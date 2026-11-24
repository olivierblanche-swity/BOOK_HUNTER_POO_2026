<?php

namespace Core;

/** Base des objets métier : propriétés communes et chargement des relations à la demande. */
abstract class Model
{
    // protected permet aux modèles enfants d'utiliser ces propriétés héritées.
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $created_at;

    /** @var array<string, bool> */
    private array $loadedRelations = [];

    // PHP appelle __get lorsqu'une propriété inaccessible est lue depuis l'extérieur.
    // Les relations doivent être déclarées protected dans les modèles enfants.
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            // Une valeur déjà chargée est réutilisée, y compris un tableau vide.
            // Une relation absente ou une moyenne null ne doit être lue qu'une fois.
            if ($this->$property === null && !isset($this->loadedRelations[$property])) {
                $methodName = 'set' . ucfirst($property);
                // Les setters spécifiques (tags, notation, books) passent avant la convention.
                if (method_exists($this, $methodName)) {
                    $this->$methodName();
                    $this->loadedRelations[$property] = true;
                } else {
                    // Convention : author → author_id → AuthorsManager.
                    $foreignKey = $property . '_id';
                    $plural = Inflect::pluralize($property);
                    $manager = '\\App\\Models\\' . ucfirst($plural) . 'Manager';

                    // Charge une relation simple seulement si sa clé et son manager existent.
                    if (property_exists($this, $foreignKey) && class_exists($manager)) {
                        $this->$property = $this->$foreignKey === null
                            ? false : $manager::findOneById($this->$foreignKey);
                        $this->loadedRelations[$property] = true;
                    }
                }
            }

            return $this->$property;
        }
        // Une propriété non déclarée donne implicitement null.
    }

    // Permet ?? dans les vues tout en respectant le chargement différé.
    public function __isset(string $property): bool
    {
        return $this->__get($property) !== null;
    }
}
