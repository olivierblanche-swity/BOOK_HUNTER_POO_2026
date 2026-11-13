<?php

namespace App\Models;

use \PDO;
use Core\DB;

abstract class BooksManager
{
    public static function findAll(int $limit = 9): array
    {
        $sql = "SELECT b.*
                FROM books b
                LEFT JOIN users_notations un ON un.book_id = b.id
                GROUP BY b.id
                ORDER BY ROUND(AVG(note),1) DESC
                LIMIT :limit;";

        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        $rs->execute();

        return $rs->fetchAll(PDO::FETCH_CLASS,'\App\Models\Book');
    }

    public static function findNotationByBookId(int $id) 
    {
        $sql = "SELECT ROUND(AVG(note),1) AS notation
                FROM books b
                LEFT JOIN users_notations un ON un.book_id = b.id
                WHERE b.id = :id;";

        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();

        return $rs->fetchColumn(0);
    }

    public static function findAllByAuthorId(int $id): array
    {
        $sql = "SELECT b.*
                FROM books b
                WHERE author_id = :id
                Order BY created_at DESC;";

        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();

        return $rs->fetchAll(PDO::FETCH_CLASS,'\App\Models\Book');
    }

}
