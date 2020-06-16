<?php

class Comment
{
    protected $database;
    public function __construct(\PDO $database = null)
    {
        if (!$database) {
            $database = new SqlitePDOConn("blog");
        }
        $this->database = $database;
    }
    public function getCommentsByCourseId($course_id)
    {
        if (empty($course_id)) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('SELECT * FROM comments WHERE course_id=:course_id');
        $statement->bindParam('course_id', $course_id);
        $statement->execute();
        $comments = $statement->fetchAll();
        if (empty($comments)) {
            // ! empty at the moment
        }
        return $comments;
    }
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
        if (empty($data['course_id']) || empty($data['rating']) || empty($data['comment'])) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('INSERT INTO comments (course_id, rating, comment) VALUES (:course_id, :rating, :comment)');
        $statement->bindParam('course_id', $data['course_id']);
        $statement->bindParam('rating', $data['rating']);
        $statement->bindParam('comment', $data['comment']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return $this->getComment($this->database->lastInsertId());
    }
    public function updateComment($data)
    {
        $this->getComment($data['comment_id']);
        $statement = $this->database->prepare('UPDATE comments SET rating=:rating, comment=:comment WHERE id=:id');
        $statement->bindParam('id', $data['comment_id']);
        $statement->bindParam('rating', $data['rating']);
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
