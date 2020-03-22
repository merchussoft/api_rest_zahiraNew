<?php

@define("RAIZ", __DIR__);
@define("APP", RAIZ . "/app/");

@define("CONTROLLERS", APP . "controllers/");
@define("MODELS", APP . "models/");
@define("ROUTERS", APP . "routers/");
@define("SYSTEMS", RAIZ . "/systems/");

/**
 * constantes para la conexion  a la base de datos
 */
@define("DB_HOST", "zahira-salon.c8wbfonri86l.us-east-1.rds.amazonaws.com:3388");
@define("DB_USER", "emily");
@define("DB_PASS", "#Emily2015");
@define("DB_NAME", "contact_zahyra");
@define("DB_PORT", "");

const SECURITY = "Rodrigo";

@define("VENDOR", RAIZ . "/vendor/");

@define('ADODB', VENDOR.'adodb/adodb-php/');
require_once(ADODB.'adodb.inc.php');
require VENDOR . "autoload.php";

