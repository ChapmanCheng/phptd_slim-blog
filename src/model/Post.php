<?php

namespace Model;

class Post
{
    protected $database;
    public function __construct(\PDO $database = null)
    {
        if (!$database) {
            $database = new \config\SqlitePDOConn("blog");
        }
        $this->database = $database;
    }
    public function getPosts()
    {
        $statement = $this->database->prepare(
            'SELECT * FROM posts ORDER BY id'
        );
        $statement->execute();
        $Posts = $statement->fetchAll();
        if (empty($Posts)) {
            //! empty at the moment
        }
        return $Posts;
    }
    public function getPost($Post_id)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM posts WHERE id=:id'
        );
        $statement->bindParam('id', $Post_id);
        $statement->execute();
        $Post = $statement->fetch();
        if (empty($Posts)) {
            //! empty at the moment
        }
        return $Post;
    }
    public function getPostBySlug($slug)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM posts WHERE slug=:slug'
        );
        $statement->bindParam('slug', $slug);
        $statement->execute();
        $post = $statement->fetch();
        if (empty($post)) {
            //! empty at the moment
        }
        return $post;
    }
    public function createPost($data)
    {
        if (empty($data['title']) || empty($data['body'])) {
            //! empty at the moment
        }
        $statement = $this->database->prepare(
            'INSERT INTO posts (title, body, tags, slug) VALUES(:title, :body, :tags, :slug)'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('body', $data['body']);
        $statement->bindParam('tags', $data['tags']);
        $statement->bindParam('slug', $data['slug']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            //! empty at the moment
        }
        return $this->getPost($this->database->lastInsertId());
    }
    public function updatePost($data)
    {
        if (empty($data['post_id']) || empty($data['title']) || empty($data['body'])) {
            //! empty at the moment
        }
        $statement = $this->database->prepare(
            'UPDATE posts SET title=:title, body=:body, tags=:tags, slug=:slug WHERE id=:id'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('body', $data['body']);
        $statement->bindParam('id', $data['post_id']);
        $statement->bindParam('tags', $data['tags']);
        $statement->bindParam('slug', $data['slug']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            //! empty at the moment
        }
        return $this->getPost($data['post_id']);
    }
    public function deletePost($post_id)
    {
        $this->getPost($post_id);
        $statement = $this->database->prepare(
            'DELETE FROM posts WHERE id=:id'
        );
        $statement->bindParam('id', $post_id);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            //! empty at the moment
        }
        return ['message' => 'The Post was deleted'];
    }
}
