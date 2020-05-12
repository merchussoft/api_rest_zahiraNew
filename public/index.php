<?php

require '../configuracion.php';
include ('../autoload.php');
spl_autoload_register('__autoload');

$settings = require SYSTEMS . 'config/setting.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

require SYSTEMS . 'config/middleware.php';
session_start();
require ROUTERS . 'Principal.php';
//require __DIR__ . '/../src/router/AdminHoras.php';
//require __DIR__ . '/../src/rutas/login.php';
// Run app
$app->run();
