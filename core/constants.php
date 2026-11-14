<?php

// URL absolue du dossier public, utilisée par la balise <base> pour les liens relatifs.
// dirname conserve le sous-dossier du projet lorsque le site n'est pas à la racine.
define('PUBLIC_BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://'
    . $_SERVER['HTTP_HOST']
    . dirname($_SERVER['PHP_SELF']) . '/');
