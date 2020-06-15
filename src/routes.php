<?php
// Routes

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

$app->get('/', function (Request $request, Response $response, array $args) {
    // * index page
    return $this->view->render($response, 'index.twig');
});

$app->get('/detail', function (Request $request, Response $response, array $args) {
    // * detail page

    return $this->view->render($response, 'detail.twig');
});

$app->get('/edit', function (Request $request, Response $response, array $args) {
    // * edit page

    return $this->view->render($response, 'edit.twig');
});

$app->get('/new', function (Request $request, Response $response, array $args) {
    // * new page

    return $this->view->render($response, 'new.twig');
});

$app->get('/pass', function (Request $request, Response $response, array $args) {
    // * password page

    return $this->view->render($response, 'password.twig');
});
