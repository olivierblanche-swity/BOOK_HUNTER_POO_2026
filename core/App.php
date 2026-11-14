<?php

namespace Core;

abstract class App
{
    public static function start(): void
    {
        session_start();

        global $title, $content;

        require_once __DIR__ . '/Title.php';
        require_once __DIR__ . '/Constants.php';
        require_once __DIR__ . '/../app/config/params.php';

        DB::setConnexion();
    }
}
