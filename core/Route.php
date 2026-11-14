<?php

namespace Core;

/** Mémorise les routes puis exécute la première correspondance. */
abstract class Route
{
    private static array $routes = [];

    public static function add(
        string $pattern,
        string $controller,
        string $action,
        array $arguments = []
    ): void {
        self::$routes[] = [$pattern, $controller, $action, $arguments];
    }

    public static function dispatch(): void
    {
        // Ignore la query string.
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (!is_string($path)) {
            return;
        }
        // REQUEST_URI encode les espaces en %20, contrairement au chemin du script.
        $path = rawurldecode($path);

        // Retire le sous-dossier du site avant de comparer les routes.
        if (BASE_PATH !== '') {
            if (!str_starts_with($path, BASE_PATH . '/')) {
                return;
            }
            $path = substr($path, strlen(BASE_PATH));
        }
        $path = ltrim($path, '/');

        foreach (self::$routes as [$pattern, $controller, $action, $arguments]) {
            if (preg_match($pattern, $path, $matches) === 1) {
                // Retire la correspondance complète pour garder les captures.
                array_shift($matches);
                $controller::$action(...array_merge($matches, $arguments));
                return;
            }
        }
    }
}
