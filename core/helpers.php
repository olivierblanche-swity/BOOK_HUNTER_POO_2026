<?php

namespace Core;


/** Outils statiques de présentation utilisés dans les vues. */
abstract class Helpers
{
    // Échappe du texte pour le HTML et ses attributs entre guillemets.
    // ENT_QUOTES traite les deux types de guillemets ; ENT_SUBSTITUTE remplace l'UTF-8 invalide.
    public static function e(?string $text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    // Raccourcit au dernier espace avant la limite, puis ajoute '...'.
    // strlen/substr comptent ici des octets, pas des caractères Unicode.

    public static function truncate($text, $limit = 100)
    {
        if (strlen($text) <= $limit)
            return $text;


        // On coupe d'abord à la limite brute
        $text = substr($text, 0, $limit);

        // On cherche la position du dernier espace
        $last_space = strrpos($text, ' ');

        // Sans espace, strrpos renvoie false : ce code produit alors seulement '...'.
        return substr($text, 0, $last_space) . '...';
    }

    // Transforme un titre en segment d'URL : lettres ASCII minuscules, chiffres et tirets.
    public static function slugify(string $text): string
    {
        // Conversion explicite pour un résultat stable avec iconv sous Windows.
        $text = strtr($text, [
            'à' => 'a', 'â' => 'a', 'ä' => 'a', 'À' => 'a', 'Â' => 'a', 'Ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e',
            'î' => 'i', 'ï' => 'i', 'Î' => 'i', 'Ï' => 'i',
            'ô' => 'o', 'ö' => 'o', 'Ô' => 'o', 'Ö' => 'o',
            'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u',
            'ç' => 'c', 'Ç' => 'c', 'ÿ' => 'y', 'Ÿ' => 'y',
            'œ' => 'oe', 'Œ' => 'oe', 'æ' => 'ae', 'Æ' => 'ae',
        ]);

        // Remplacer les caractères accentués par leur équivalent
        $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

        // Mettre en minuscules
        $text = strtolower($text);

        // Remplacer tout ce qui n'est pas une lettre ou un chiffre par un tiret
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        // Supprimer les tirets au début et à la fin
        $text = trim($text, '-');

        // Retourner la chaîne ou une valeur par défaut si vide
        return empty($text) ? 'n-a' : $text;
    }


    // strtotime interprète la date reçue ; date la reformate selon les codes PHP.
    // Exemple : 'd/M/Y' affiche le jour, le mois abrégé en anglais et l'année.

    public static function dateFormator(string $date, string $format = "d/M/Y"): string
    {
        return date($format, strtotime($date));
    }
}
