<?php 

namespace Core;

/** Capture les sections des vues pour alimenter les variables globales du template. */
abstract class AppTemplate
{
    // Une seule section peut être capturée à la fois : les sections ne sont pas imbriquées.
    private static $currentSection;

    public static function section(string $section): void
    {
        self::$currentSection = $section;
        // Les sorties suivantes sont gardées en mémoire au lieu d'être envoyées au navigateur.
        ob_start();
    }

    public static function stop(): void
    {
        // Variable variable : la section 'content' désigne $content, 'title' désigne $title.
        global ${ self::$currentSection };
        // Récupère le HTML capturé et ferme le tampon ouvert par section().
        ${ self::$currentSection } = ob_get_clean();
    }
}
