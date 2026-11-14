<?php

require_once __DIR__ . '/../vendor/autoload.php';

\Core\App::start();

require_once __DIR__ . '/../app/routers/index.php';
require_once __DIR__ . '/../app/views/templates/default.php';
