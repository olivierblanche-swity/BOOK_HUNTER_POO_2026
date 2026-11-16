<?php

// Chemin absolu sur l'origine courante : aucune dépendance au Host ou au proxy.
// Encode chaque segment pour conserver les espaces et les sous-dossiers.
define('PUBLIC_BASE_URL', implode('/', array_map('rawurlencode', explode('/', BASE_PATH))) . '/');
