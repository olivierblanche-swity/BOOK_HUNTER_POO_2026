<?php 

namespace Core;
use \PDO;

/** Requêtes de lecture communes ; PDO transforme les lignes SQL en objets du modèle. */
abstract class Manager 


{
    // Chaque manager concret déclare les seules colonnes SQL triables.
    protected const SORTABLE_COLUMNS = ['id', 'created_at'];

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

    // null désactive la limite ; par défaut, les ajouts les plus récents passent en premier.
    public static function findAll(?int $limit = 10, string $orderBy = 'created_at', string $direction = 'DESC'): array
    {
        [$table, $model] = static::init();
        // Un nom de colonne ne se lie pas comme une valeur PDO : on le vérifie avant insertion.
        if (!in_array($orderBy, static::SORTABLE_COLUMNS, true)) {
            throw new \InvalidArgumentException('Colonne de tri inconnue : ' . $orderBy);
        }
        if ($limit !== null && $limit < 0) {
            throw new \InvalidArgumentException('La limite doit etre positive ou nulle.');
        }
        // Le sens du tri est inséré dans le SQL : seules ces deux valeurs sont autorisées.
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new \InvalidArgumentException('Sens de tri inconnu : ' . $direction);
        }

        $sql = 'SELECT *
                FROM `'. $table .'`
                ORDER BY `' . $orderBy . '` ' . $direction;
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

    // fetchObject() renvoie false si aucun enregistrement ne correspond.
    public static function findOneById(int $id): object|false
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
