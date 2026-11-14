<?php

namespace Core;


abstract class Helpers
{
    public static function e(?string $text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    // fonction pour couper dans les textes trop long 

    public static function truncate($text, $limit = 100)
    {
        if (strlen($text) <= $limit)
            return $text;


        // On coupe d'abord à la limite brute
        $text = substr($text, 0, $limit);

        // On cherche la position du dernier espace
        $last_space = strrpos($text, ' ');

        // On recoupe au niveau du dernier espace et on ajoute des points de suspension
        return substr($text, 0, $last_space) . '...';
    }

    // fonction pour faire les slug
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


    // fonction pour le format des dates 

    public static function dateFormator(string $date, string $format = "d/M/Y"): string
    {
        return date($format, strtotime($date));
    }
}
