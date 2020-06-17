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

$app->map(['GET', 'POST'], '/blog/{slug}', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();
    $comment = new \Model\Comment();

    $slug = filter_var($args['slug'], FILTER_SANITIZE_STRING);
    $path = htmlspecialchars($request->getUri()->getPath());

    switch ($request->getMethod()) {
        case 'POST':
            $postBody = $request->getParsedBody();
            $mailer = new Mailer($postBody);
            $mailer->addPostID($id);

            $comment->createComment($mailer->getPostData());
            break;

        default:
            $blog = $post->getPostBySlug($slug);
            return $this->view->render($response, 'detail.twig', [
                'post' => $blog,
                'comments' => $comment->getCommentsByCourseId($blog['id']),
                'path' => $path
            ]);
    }
});


$app->map(['GET', 'PUT', 'DELETE'], '/edit', function (Request $request, Response $response, array $args) {
    $post = new \Model\Post();

    $params = $request->getQueryParams();
    $id = filter_var($params['id'], FILTER_SANITIZE_NUMBER_INT);
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath());

    switch ($request->getMethod()) {
        case 'PUT':
            $postBody = $request->getParsedBody();
            $mailer = new Mailer($postBody);
            $mailer->addPostID($id);
            $mailer->slugifyTitle();

            if ($mailer->lookForTags())
                $mailer->stripTagsFromBody()->addTags();

            $upPost = $post->updatePost($mailer->getPostData());
            return $response->withRedirect("/blog/$upPost[slug]");
        case 'DELETE':
            $post->deletePost($id);
            return $response->withRedirect('/');

        default:
            return $this->view->render($response, 'edit.twig', [
                'post' => $post->getPost($id),
                'path' => $path
            ]);
            break;
    }
});

$app->map(['GET', 'POST'], '/new', function (Request $request, Response $response, array $args) {
    $uri = $request->getUri();
    $path = htmlspecialchars($uri->getPath());

    switch ($request->getMethod()) {
        case 'POST':
            $post = new \Model\Post();

            $postBody = $request->getParsedBody();
            $mailer = new Mailer($postBody);
            $mailer->slugifyTitle();


            if ($mailer->lookForTags())
                $mailer->stripTagsFromBody()->addTags();

            $newPost = $post->createPost($mailer->getPostData());

            if ($newPost)
                return $response->withRedirect("/blog/$newPost[slug]");
            else
                return $this->view->render($response, 'new.twig', [
                    'path' => $path,
                    'post' => $newPost
                ]);
            break;

        default:
            return $this->view->render($response, 'new.twig', [
                'path' => $path
            ]);
            break;
    }
});

// ! unused material
// $app->get('/pass', function (Request $request, Response $response, array $args) {
//     // * password page

//     return $this->view->render($response, 'password.twig');
// });
