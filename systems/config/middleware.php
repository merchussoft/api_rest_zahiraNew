<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->add(function($request, $response, $next) {
    $route = $request->getAttribute("route");
    $methods = [];
    if (!empty($route)) {
        $pattern = $route->getPattern();

        foreach ($this->router->getRoutes() as $route) {
            if ($pattern === $route->getPattern()) {
                $methods = array_merge_recursive($methods, $route->getMethods());
            }
        }
        //Methods holds all of the HTTP Verbs that a particular route handles.
    } else {
        $methods[] = $request->getMethod();
    }
    $response = $next($request, $response);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
        ->withHeader("Access-Control-Allow-Credentials", true);
});