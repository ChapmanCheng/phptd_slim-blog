<?php

namespace Model;

class Post
{
    protected $database;
    public function __construct(\PDO $database = null)
    {
        if (!$database) {
            $database = new \SqlitePDOConn("blog");
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
    public function createPost($data)
    {
        if (empty($data['title']) || empty($data['url'])) {
            //! empty at the moment
        }
        $statement = $this->database->prepare(
            'INSERT INTO posts (title, url) VALUES(:title, :url)'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('url', $data['url']);
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
            'UPDATE posts SET title=:title, body=:body WHERE id=:id'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('body', $data['body']);
        $statement->bindParam('id', $data['post_id']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            //! empty at the moment
        }
        return $this->getPost($data['post_id']);
    }
    public function deletePost($Post_id)
    {
        $this->getPost($Post_id);
        $statement = $this->database->prepare(
            'DELETE FROM posts WHERE id=:id'
        );
        $statement->bindParam('id', $Post_id);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            //! empty at the moment
        }
        return ['message' => 'The Post was deleted'];
    }
}
