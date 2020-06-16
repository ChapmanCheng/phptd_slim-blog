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

    return $this->view->render($response, 'index.twig', [
        'posts' => $post->getPosts()
    ]);
});

$app->map(['GET', 'POST'], '/detail', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();
    $comment = new \Model\Comment();

    $params = $request->getQueryParams();
    $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath() . '?' . $uri->getQuery());

    if ($request->isPost()) {
        $newComment = filter_var_array($request->getParsedBody(), FILTER_SANITIZE_STRING);
        $newComment["post_id"] = $id;

        $comment->createComment($newComment);
    }

    return $this->view->render($response, 'detail.twig', [
        'post' => $post->getPost($id),
        'comments' => $comment->getCommentsByCourseId($id),
        'path' => $path
    ]);
});


$app->map(['GET', 'POST'], '/edit', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();

    $params = $request->getQueryParams();
    $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath() . '?' . $uri->getQuery());

    if ($request->isPost()) {
        $updateComment = filter_var_array($request->getParsedBody(), FILTER_SANITIZE_STRING);
        $updateComment["post_id"] = $id;

        $upPost = $post->updatePost($updateComment);

        // TODO: redirect to "/detail?:id"
    }


    return $this->view->render($response, 'edit.twig', [
        'post' => $post->getPost($id),
        'path' => $path
    ]);
});

$app->get('/new', function (Request $request, Response $response, array $args) {
    // * new page

    return $this->view->render($response, 'new.twig');
});

$app->get('/pass', function (Request $request, Response $response, array $args) {
    // * password page

    return $this->view->render($response, 'password.twig');
});
