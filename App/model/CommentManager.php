<?php

namespace App\model;


class CommentManager extends Manager
{

    public function add($comment)
    {
        $message = 'Only registered users can write comments';
        if (!empty($_SESSION['user'])) {


            $comments = $this->getDb()->prepare('INSERT INTO comment (user_id, post_id, creation_date, content) VALUES (:user_id, :post_id, :creationDate, :content)');

            $comments->execute([
                ':user_id' => $comment->getUserId(),
                ':post_id' => $comment->getPostId(),
                ':creationDate' => date('Y-m-d H:i:s'),
                ':content' => $comment->getContent()
            ]);
            $message = 'Thank you, your comment will be validated by the admin';
        }
        return $message;
    }

    public function publish($commentId)
    {
        $statement = $this->getDb()->prepare('UPDATE comment SET published = 1 WHERE comment_id = ?');
        $statement->execute(array($commentId));
    }

    public function getComment($commentId)
    {
        $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE comment_id = ?');
        $statement->execute(array($commentId));
        $comment = $statement->fetchObject();
        return $comment;
    }

    public function listComments($postId)
    {
        $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE post_id = ? AND published = 1 ORDER BY creation_date DESC');
        if (isset($_SESSION['user']) && 1 == $_SESSION['user']['role']) {
            $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE post_id = ? ORDER BY creation_date DESC');
        }
        $statement->execute(array($postId));
        $comments = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $comments;
    }

    public function delete($commentId)
    {
        $statement = $this->getDb()->prepare('DELETE FROM comment WHERE comment_id = :comment_id');
        $statement->execute([
            ':comment_id' => $commentId
        ]);
        //var_dump($this->getPost($blogpost->getPostId()));
        //return $this->getPost($blogpost->getPostId());
    }
}
