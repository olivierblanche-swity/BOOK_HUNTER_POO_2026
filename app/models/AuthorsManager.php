<?php

namespace App\Models;
use \PDO;
use Core\DB;

abstract class AuthorsManager extends \Core\Manager {

Protected static $table = 'authors';

    public static function findNotationByAuthorId(int $id)
    {
        $sql = 'SELECT ROUND(AVG(un.note), 1)
                FROM books b
                JOIN users_notations un ON un.book_id = b.id
                WHERE b.author_id = :id;';

        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();

        return $rs->fetchColumn();
    }


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

    

    



}
