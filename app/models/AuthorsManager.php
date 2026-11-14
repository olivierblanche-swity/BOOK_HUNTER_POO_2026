<?php

namespace App\Models;
use \PDO;
use Core\DB;

abstract class AuthorsManager {


    public static function findAllPopulars(int $limit = 9): array
    {
        $sql = "SELECT au.*
                        
                FROM books b 
                JOIN authors au ON b.author_id = au.id
                LEFT JOIN users_notations un ON un.book_id = b.id
                GROUP BY au.id
                ORDER BY ROUND(AVG(note),1) DESC
                LIMIT :limit";

        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        $rs->execute();

        return $rs->fetchAll(PDO::FETCH_CLASS,'\App\Models\Author');


    }

    public static function findOneById (int $id): Author
    {
        $sql = "SELECT au.*
                FROM authors au 
                WHERE id = :id;";

        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();

        return $rs->fetchObject('\App\Models\Author');

    }

    public static function findAll(int $limit = 10): array
    {
        $sql = 'SELECT a.*
                FROM authors a
                ORDER BY created_at
                LIMIT :limit;';
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        $rs->execute();
        
        return $rs->fetchAll(PDO::FETCH_CLASS, '\App\Models\Author');
    }



}
