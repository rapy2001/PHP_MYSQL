<?php

    class Comment extends dbh
    {
        public function createComment($user_id,$comment_text,$scream_id)
        {
            $connection = $this->connection();
            $sql = "INSERT INTO comments(user_id, comment_text, scream_id) VALUES(?,?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$comment_text,$scream_id]);
        }

        public function getAllScreamComments($scream_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM comments WHERE scream_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$scream_id]);
            $comments = $stmt->fetchAll();
            return $comments;
        }

        public function getCommentWithId($comment_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM comments WHERE comment_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$comment_id]);
            $comment = $stmt->fetch();
            return $comment;
        }

        public function deleteComment($comment_id)
        {
            $connection = $this->connection();
            $sql = "DELETE FROM comments WHERE comment_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$comment_id]);
        }

        public function updateComment($commentId,$commentText)
        {
            $connection = $this->connection();
            $sql = "UPDATE comments SET comment_text = ?, created_at= NOW() WHERE comment_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$commentText,$commentId]);
        }
    }
?>