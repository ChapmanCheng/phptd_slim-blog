<?php
// Routes

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

$app->get('/', function (Request $request, Response $response, array $args) {
    // * index page

});

$app->get('/detail', function (Request $request, Response $response, array $args) {
    // * detail page

});

$app->get('/edit', function (Request $request, Response $response, array $args) {
    // * edit page

});

$app->get('/new', function (Request $request, Response $response, array $args) {
    // * new page

});

$app->get('/password', function (Request $request, Response $response, array $args) {
    // * password page

});
