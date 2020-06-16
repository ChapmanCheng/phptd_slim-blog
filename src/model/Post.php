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
        if (empty($data['title']) || empty($data['body'])) {
            //! empty at the moment
        }
        $statement = $this->database->prepare(
            'INSERT INTO posts (title, body) VALUES(:title, :body)'
        );
        $statement->bindParam('title', $data['title']);
        $statement->bindParam('body', $data['body']);
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
