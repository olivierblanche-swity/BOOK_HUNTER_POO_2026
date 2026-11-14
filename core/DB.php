<?php

namespace Core;

/** Centralise la connexion PDO utilisée par tous les managers pendant la requête. */
abstract class DB{
    // Les propriétés statiques conservent leur valeur entre les appels de méthodes.
    private static $connexion = null;
    private static $connexionIsDefined = false;

public static function setConnexion() 

{
    // Le drapeau évite une deuxième tentative, même si la première connexion a échoué.
    if (!SELF::$connexionIsDefined):
        try {
            // Les constantes de connexion sont définies dans app/config/params.php.
            SELF::$connexion = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPWD);
            } 
        catch (\PDOException $e) {
            // Comportement actuel : affiche le détail de l'erreur (à retirer à l'étape 20).
            echo $e->getMessage();
            }
        SELF::$connexionIsDefined = true;
    endif;  
}
    

// Renvoie la connexion préparée par App::start(), sans en créer une nouvelle.
public static function getConnexion() {
    return SELF::$connexion;
    }
}
