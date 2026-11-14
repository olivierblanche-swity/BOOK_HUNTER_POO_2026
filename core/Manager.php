<?php 

namespace Core;
use \PDO;

abstract class Manager 


{
    protected static $table;
    protected static $model;

    public static function findAll(?int $limit = 10, string $orderBy = 'created_at'): array
    {
        $model = static::$model ?? '\\App\\Models\\' . ucfirst(substr(static::$table, 0, -1));
        if (!property_exists($model, $orderBy)) {
            throw new \InvalidArgumentException('Colonne de tri inconnue : ' . $orderBy);
        }
        if ($limit !== null && $limit < 0) {
            throw new \InvalidArgumentException('La limite doit etre positive ou nulle.');
        }

        $sql = 'SELECT *
                FROM `'. static::$table .'`
                ORDER BY `' . $orderBy . '`';
        if ($limit !== null) {
            $sql .= ' LIMIT :limit';
        }
        $rs = DB::getConnexion()->prepare($sql);
        if ($limit !== null) {
            $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $rs->execute();
        
        return $rs->fetchAll(PDO::FETCH_CLASS, $model);
    }

    public static function findOneById(int $id): object
    {
        $sql = 'SELECT *
                FROM `'. static::$table .'`
                WHERE id = :id;';
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        
        $model = static::$model ?? '\\App\\Models\\' . ucfirst(substr(static::$table, 0, -1));
        return $rs->fetchObject($model);
    }
}
