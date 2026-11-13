<?php

namespace Core;

abstract class DB{
    private static $connexion = null;
    private static $connexionIsDefined = false;

public static function setConnexion() 

{
    if (!SELF::$connexionIsDefined):
        try {
            SELF::$connexion = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPWD);
            } 
        catch (\PDOException $e) {
            echo $e->getMessage();
            }
        SELF::$connexionIsDefined = true;
    endif;  
}
    

public static function getConnexion() {
    return SELF::$connexion;
    }
}