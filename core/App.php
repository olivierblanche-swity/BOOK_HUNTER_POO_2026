<?php

namespace Core;

/** Point de démarrage : prépare la session, la configuration et la connexion PDO. */
abstract class App
{
    public static function start(): void
    {
        // Journalise les erreurs sans exposer leurs détails au visiteur.
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');
        error_reporting(E_ALL);

        // Doit être exécuté avant toute sortie HTML pour envoyer les cookies de session.
        session_start();

        // Les fichiers inclus ici partagent la portée de cette méthode.
        // global garde ces deux zones accessibles au template chargé par index.php.
        global $title, $content;

        require_once __DIR__ . '/Title.php';
        // Chemin du dossier public dans l'URL ; chaîne vide à la racine.
        define(
            'BASE_PATH',
            rtrim(rawurldecode(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']))), '/')
        );

        require_once __DIR__ . '/Constants.php';
        require_once __DIR__ . '/../app/config/params.php';

        // Initialise la connexion partagée avant les appels aux managers.
        DB::setConnexion();
    }
}
