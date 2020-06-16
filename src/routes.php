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

$app->map(['GET', 'POST'], '/detail', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();
    $comment = new \Model\Comment();

    $params = $request->getQueryParams();
    $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);

    if ($request->isPost()) {
        $newComment = filter_var_array($request->getParsedBody(), FILTER_SANITIZE_STRING);
        $newComment["post_id"] = $id;

        $comment->createComment($newComment);
    }

    return $this->view->render(
        $response,
        'detail.twig',
        [
            'post' => $post->getPost($id),
            'comments' => $comment->getCommentsByCourseId($id),
            'path' => htmlspecialchars($request->getUri()->getPath())
        ]
    );
});


$app->get('/edit', function (Request $request, Response $response, array $args) {
    // * edit page
    // $params = $request->getQueryParams();
    // $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);

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
