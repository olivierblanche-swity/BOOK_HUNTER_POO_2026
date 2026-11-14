<?php 

namespace Core;
use \PDO;

/** Requêtes de lecture communes ; PDO transforme les lignes SQL en objets du modèle. */
abstract class Manager 


{
    private static function init(): array
    {
        // static::class désigne le manager appelé, par exemple BooksManager.
        // Remplace les séparateurs du namespace pour isoler le nom de classe avec basename.
        $class = basename(str_replace('\\', '/', static::class));
        $table = strtolower(str_replace('Manager', '', $class));
        // Convention : tables au pluriel en s, avec l'exception categories → Category.
        $singular = $table === 'categories' ? 'category' : substr($table, 0, -1);
        $model = '\\App\\Models\\' . ucfirst($singular);

        // Ces valeurs locales sont recalculées à chaque appel.
        return [$table, $model];
    }

    // null désactive la limite ; sans DESC, le tri SQL est croissant.
    public static function findAll(?int $limit = 10, string $orderBy = 'created_at'): array
    {
        [$table, $model] = static::init();
        // Un nom de colonne ne se lie pas comme une valeur PDO : on le vérifie avant insertion.
        // Cette convention suppose que la propriété demandée correspond à une colonne SQL.
        if (!property_exists($model, $orderBy)) {
            throw new \InvalidArgumentException('Colonne de tri inconnue : ' . $orderBy);
        }
        if ($limit !== null && $limit < 0) {
            throw new \InvalidArgumentException('La limite doit etre positive ou nulle.');
        }

        $sql = 'SELECT *
                FROM `'. $table .'`
                ORDER BY `' . $orderBy . '`';
        if ($limit !== null) {
            $sql .= ' LIMIT :limit';
        }
        $rs = DB::getConnexion()->prepare($sql);
        if ($limit !== null) {
            // LIMIT attend un entier ; le type explicite évite de le transmettre comme une chaîne.
            $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $rs->execute();
        
        // Chaque ligne devient un objet ; les colonnes alimentent les propriétés de même nom.
        return $rs->fetchAll(PDO::FETCH_CLASS, $model);
    }

    // À l'étape 21, prévoir aussi l'absence de résultat : fetchObject() peut renvoyer false,
    // ce qui est actuellement incompatible avec le type de retour object.
    public static function findOneById(int $id): object
    {
        [$table, $model] = static::init();

        $sql = 'SELECT *
                FROM `'. $table .'`
                WHERE id = :id;';
        $rs = DB::getConnexion()->prepare($sql);
        // La requête préparée sépare l'identifiant des instructions SQL.
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        
        return $rs->fetchObject($model);
    }
}
