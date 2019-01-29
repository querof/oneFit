<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__."/../autoloader.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use src\Routing\Routes;

function render_template(Request $request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/Controller/%s.php', $_route);

    return new Response(ob_get_clean());
}

$request = Request::createFromGlobals();
$routes = new Routes();

try {
    $response = $routes->callRoute($request);
} catch (Exception $exception) {
    $response = new Response();
    $response->setStatusCode(500);
    $response->setContent(json_encode(array(
          'error' => $exception->getMessage(),
      )));
    $response->headers->set('Content-Type', 'application/json');
}

$response->send();
