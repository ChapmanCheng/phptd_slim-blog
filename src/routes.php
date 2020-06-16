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
    $post = new \Model\Post();

    $view = $this->view->render(
        $response,
        'index.twig',
        ['posts' => $post->getPosts()]
    );

    return $view;
});

    $post = new \Model\Post();

    $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
    $post = new Post();
    // $comment = new Comment();

    return $this->view->render(
        $response,
        'detail.twig',
        [
            'post' => $post->getPost($id),
            // 'comments'=>
        ]
    );
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
