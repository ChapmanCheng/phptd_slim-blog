<?php
// Routes

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Model\Mailer;

$app->get('/', function (Request $request, Response $response, array $args) {
    // * index page
    $post = new \Model\Post();

    return $this->view->render($response, 'index.twig', [
        'posts' => $post->getPosts()
    ]);
});

$app->map(['GET', 'POST'], '/blog', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();
    $comment = new \Model\Comment();

    $params = $request->getQueryParams();
    $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath());

    if ($request->isPost()) {
        $postBody = $request->getParsedBody();
        $mailer = new Mailer($postBody);
        $mailer->addPostID($id);

        $comment->createComment($mailer->getPostData());
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
        $postBody = $request->getParsedBody();
        $mailer = new Mailer($postBody);
        $mailer->addPostID($id);

        if ($mailer->lookForTags())
            $mailer->stripTagsFromBody()->addTags();

        $upPost = $post->updatePost($mailer->getPostData());
        return $response->withRedirect("/blog?id=$upPost[id]");
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

        $postBody = $request->getParsedBody();
        $mailer = new Mailer($postBody);


        if ($mailer->lookForTags())
            $mailer->stripTagsFromBody()->addTags();

        $newPost = $post->createPost($mailer->getPostData());

        if ($newPost)
            return $response->withRedirect("/blog?id=$newPost[id]");
        else
            return $this->view->render($response, 'new.twig', [
                'path' => $path,
                'post' => $newPost
            ]);
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
