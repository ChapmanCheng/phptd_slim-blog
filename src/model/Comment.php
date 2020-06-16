<?php

namespace Model;

class Comment
{
    protected $database;
    public function __construct(\PDO $database = null)
    {
        if (!$database) {
            $database = new \SqlitePDOConn("blog");
        }
        $this->database = $database;
    }
    public function getCommentsByCourseId($post_id)
    {
        if (empty($post_id)) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('SELECT * FROM comments WHERE post_id=:post_id ORDER BY created_at DESC');
        $statement->bindParam('post_id', $post_id);
        $statement->execute();
        $comments = $statement->fetchAll();
        if (empty($comments)) {
            // ! empty at the moment
        }
        return $comments;
    }
    // ! can delete 
    public function getComment($comment_id)
    {
        if (empty($comment_id)) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('SELECT * FROM comments WHERE id=:id');
        $statement->bindParam('id', $comment_id);
        $statement->execute();
        $comment = $statement->fetch();
        if (empty($comment)) {
            // ! empty at the moment
        }
        return $comment;
    }
    public function createComment($data)
    {
        if (empty($data['post_id']) || empty($data['name']) || empty($data['body'])) {
            echo "comment is empty, please try again";
            die();
        }
        $statement = $this->database->prepare('INSERT INTO comments (post_id, name, body) VALUES (:post_id, :name, :body)');
        $statement->bindParam('post_id', $data['post_id']);
        $statement->bindParam('name', $data['name']);
        $statement->bindParam('body', $data['body']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return $this->getComment($this->database->lastInsertId());
    }
    public function updateComment($data)
    {
        $this->getComment($data['comment_id']);
        $statement = $this->database->prepare('UPDATE comments SET name=:name, comment=:comment WHERE id=:id');
        $statement->bindParam('id', $data['comment_id']);
        $statement->bindParam('name', $data['name']);
        $statement->bindParam('comment', $data['comment']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return $this->getComment($data['comment_id']);
    }
    public function deleteComment($comment_id)
    {
        $this->getComment($comment_id);
        $statement = $this->database->prepare('DELETE FROM comments WHERE id=:id');
        $statement->bindParam('id', $comment_id);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return ['message' => 'The comment was deleted.'];
    }
}
