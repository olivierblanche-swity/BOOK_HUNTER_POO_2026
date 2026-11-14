<?php 

namespace Core;
use \PDO;

abstract class Manager 


{
    protected static $table;

    public static function findAll(int $limit = 10): array
    {
        $sql = 'SELECT *
                FROM `'. static::$table .'`
                ORDER BY created_at
                LIMIT :limit;';
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        $rs->execute();
        
        return $rs->fetchAll(PDO::FETCH_CLASS,'\App\Models\\' .ucFirst(substr(static::$table, 0, -1)));
    }

    public static function findOneById(int $id): object
    {
        $sql = 'SELECT *
                FROM `'. static::$table .'`
                WHERE id = :id;';
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        
        return $rs->fetchObject('\App\Models\\' .ucFirst(substr(static::$table, 0, -1)));
    }
}