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
    // Le découpage Unicode ne nécessite pas l'extension mbstring.
    public static function truncate(string $text, int $limit = 100): string
    {
        if ($limit < 0) {
            throw new \InvalidArgumentException('La limite doit être positive ou nulle.');
        }
        if (preg_match_all('/./us', $text, $characters) === false) {
            throw new \InvalidArgumentException('Le texte doit être en UTF-8 valide.');
        }
        if (count($characters[0]) <= $limit)
            return $text;
        if ($limit === 0) {
            return '';
        }
        $text = implode('', array_slice($characters[0], 0, $limit));
        $last_space = strrpos($text, ' ');
        return rtrim($last_space !== false && $last_space > 0
            ? substr($text, 0, $last_space) : $text) . '...';
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


    // Par défaut : jour, mois français en entier et année (ex. 16 novembre 2026).
    // Un format PHP explicite reste disponible pour les dates numériques.
    public static function dateFormator(?string $date, ?string $format = null): string
    {
        if ($date === null || trim($date) === '') {
            return 'Date non renseignée';
        }
        $timestamp = strtotime($date);
        $errors = date_parse($date);
        if ($timestamp === false || $errors['warning_count'] > 0 || $errors['error_count'] > 0) {
            return 'Date invalide';
        }
        if ($format !== null) {
            return date($format, $timestamp);
        }
        $months = [
            1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre',
        ];
        return date('j', $timestamp) . ' ' . $months[(int) date('n', $timestamp)]
            . ' ' . date('Y', $timestamp);
    }
}
