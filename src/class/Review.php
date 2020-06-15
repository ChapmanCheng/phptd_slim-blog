<?php

class Review
{
    protected $database;
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }
    public function getReviewsByCourseId($course_id)
    {
        if (empty($course_id)) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('SELECT * FROM reviews WHERE course_id=:course_id');
        $statement->bindParam('course_id', $course_id);
        $statement->execute();
        $reviews = $statement->fetchAll();
        if (empty($reviews)) {
            // ! empty at the moment
        }
        return $reviews;
    }
    public function getReview($review_id)
    {
        if (empty($review_id)) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('SELECT * FROM reviews WHERE id=:id');
        $statement->bindParam('id', $review_id);
        $statement->execute();
        $review = $statement->fetch();
        if (empty($review)) {
            // ! empty at the moment
        }
        return $review;
    }
    public function createReview($data)
    {
        if (empty($data['course_id']) || empty($data['rating']) || empty($data['comment'])) {
            // ! empty at the moment
        }
        $statement = $this->database->prepare('INSERT INTO reviews (course_id, rating, comment) VALUES (:course_id, :rating, :comment)');
        $statement->bindParam('course_id', $data['course_id']);
        $statement->bindParam('rating', $data['rating']);
        $statement->bindParam('comment', $data['comment']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return $this->getReview($this->database->lastInsertId());
    }
    public function updateReview($data)
    {
        $this->getReview($data['review_id']);
        $statement = $this->database->prepare('UPDATE reviews SET rating=:rating, comment=:comment WHERE id=:id');
        $statement->bindParam('id', $data['review_id']);
        $statement->bindParam('rating', $data['rating']);
        $statement->bindParam('comment', $data['comment']);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return $this->getReview($data['review_id']);
    }
    public function deleteReview($review_id)
    {
        $this->getReview($review_id);
        $statement = $this->database->prepare('DELETE FROM reviews WHERE id=:id');
        $statement->bindParam('id', $review_id);
        $statement->execute();
        if ($statement->rowCount() < 1) {
            // ! empty at the moment
        }
        return ['message' => 'The review was deleted.'];
    }
}
