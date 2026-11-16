<?php
define('BASE_PATH', $argv[1] ?? '');
require __DIR__ . '/../core/Constants.php';
$expected = $argv[2] ?? '/';
if (PUBLIC_BASE_URL !== $expected) { throw new RuntimeException('Base incorrecte'); }
echo "Chemin de base validé\n";
