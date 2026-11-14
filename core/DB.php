<?php

namespace Core;

/** Centralise la connexion PDO utilisée par tous les managers pendant la requête. */
abstract class DB{
    // Les propriétés statiques conservent leur valeur entre les appels de méthodes.
    private static $connexion = null;
    private static $connexionIsDefined = false;

public static function setConnexion() 

{
    // Le drapeau évite de recréer une connexion déjà initialisée.
    if (!SELF::$connexionIsDefined):
        // Les constantes de connexion sont définies dans app/config/params.php.
        SELF::$connexion = new \PDO(
            'mysql:host=' . DBHOST . ';dbname=' . DBNAME,
            DBUSER,
            DBPWD
        );
        SELF::$connexionIsDefined = true;
    endif;  
}
    

// Renvoie la connexion préparée par App::start(), sans en créer une nouvelle.
public static function getConnexion() {
    return SELF::$connexion;
    }
}
