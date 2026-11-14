<?php 

namespace Core;

abstract class AppTemplate
{
    private static $currentSection;

    public static function section(string $section): void
    {
        self::$currentSection = $section;
        ob_start();
    }

    public static function stop(): void
    {
        global ${ self::$currentSection };
        ${ self::$currentSection } = ob_get_clean();
    }
}
