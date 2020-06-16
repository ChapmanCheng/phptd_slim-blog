<?php
// Routes

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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
    $path = htmlspecialchars($uri->getPath());

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


$app->map(['GET', 'PUT', 'DELETE'], '/edit', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();

    $params = $request->getQueryParams();
    $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath());

    if ($request->isPut()) {
        $upPost = filter_var_array($request->getParsedBody(), FILTER_SANITIZE_STRING);
        $upPost["post_id"] = $id;

        $upPost = $post->updatePost($upPost);
        return $response->withRedirect("/detail?id=$upPost[id]");
    } elseif ($request->isDelete()) {
        $post->deletePost($id);
        return $response->withRedirect('/');
    }

    return $this->view->render($response, 'edit.twig', [
        'post' => $post->getPost($id),
        'path' => $path
    ]);
});

$app->map(['GET', 'POST'], '/new', function (Request $request, Response $response, array $args) {
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath());

    if ($request->isPost()) {
        $post = new \Model\Post();
        $newPost = filter_var_array($request->getParsedBody(), FILTER_SANITIZE_STRING);
        $newPost = $post->createPost($newPost);

        if ($newPost) {
            return $response->withRedirect("/detail?id=$newPost[id]");
        } else {
            return $this->view->render($response, 'new.twig', [
                'path' => $path,
                'post' => $newPost
            ]);
        }
    }

    return $this->view->render($response, 'new.twig', [
        'path' => $path
    ]);
});

// ! unused material
// $app->get('/pass', function (Request $request, Response $response, array $args) {
//     // * password page

//     return $this->view->render($response, 'password.twig');
// });
