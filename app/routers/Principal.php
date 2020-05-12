<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get("/zahira_api/", function (Request $request, Response $response) {
    $usuarios = new Usuarios();
    $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($usuarios->login()));
});

$app->post("/zahira_api/login", function (Request $request, Response $response) {
    try {
        $usuarios = new Usuarios();
        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($usuarios->login($request->getParsedBody())));

    } catch (PDOException $e) {
        return $response
            ->withStatus(503)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array('error' => array("text" => $e->getMessage()))));
    }
});

$app->get("/zahira_api/cerrar_session", function(Request $request, Response $response){
  $usuarios = new Usuarios();
  return $response
    ->withStatus(200)
    ->withHeader('Content-Type', 'application/json')
    ->write(json_encode($usuarios->cerrarSession()));
});
