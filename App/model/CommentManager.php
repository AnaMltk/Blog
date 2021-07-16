<?php

namespace App\model;
use \App\controller\Session;

class CommentManager extends Manager
{

    /**
     * @param mixed $comment
     * 
     * @return string
     */
    public function add($comment): string
    {
        $session = new Session();
        $message = 'Seulement les utilisateurs enregistrés peuvent écrire des commentaires';
        if (!empty($session->read('user'))) {

            $comments = $this->getDb()->prepare('INSERT INTO comment (user_id, post_id, creation_date, content) VALUES (:user_id, :post_id, :creationDate, :content)');

            $comments->execute([
                ':user_id' => $comment->getUserId(),
                ':post_id' => $comment->getPostId(),
                ':creationDate' => date('Y-m-d H:i:s'),
                ':content' => $comment->getContent()
            ]);
            $message = 'Votre commentaire sera publié après la validation par Admin';
        }
        return $message;
    }

    /**
     * @param int $commentId
     * 
     * @return void
     */
    public function publish(int $commentId): void
    {
        $statement = $this->getDb()->prepare('UPDATE comment SET published = 1 WHERE comment_id = ?');
        $statement->execute(array($commentId));
    }

    /**
     * @param mixed $commentId
     * 
     * @return [type]
     */
    public function getComment($commentId)
    {
        $statement = $this->getDb()->prepare('SELECT comment.comment_id, comment.content, comment.post_id, comment.creation_date, comment.published, comment.user_id, user.login FROM comment INNER JOIN user ON comment.user_id=user.user_id WHERE comment_id = ?');
        $statement->execute(array($commentId));
        $comment = $statement->fetchObject();
        return $comment;
    }

    /**
     * @param mixed $postId
     * 
     * @return array
     */
    public function listComments($postId): array
    {
        $session = new Session();
        $userInformation = $session->read('user');
        $userRole = $userInformation['role'];

        $statement = $this->getDb()->prepare('SELECT comment.comment_id, comment.content, comment.post_id, comment.creation_date, comment.published, comment.user_id, user.login FROM comment INNER JOIN user ON comment.user_id=user.user_id WHERE post_id = ? AND published = 1 ORDER BY creation_date DESC');
        if (isset($userInformation) && 1 == $userRole) {
            $statement = $this->getDb()->prepare('SELECT comment.comment_id, comment.content, comment.post_id, comment.creation_date, comment.published, comment.user_id, user.login FROM comment INNER JOIN user ON comment.user_id=user.user_id WHERE post_id = ? ORDER BY creation_date DESC');
        }
        $statement->execute(array($postId));
        $comments = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $comments;
    }

    public function listUnpublishedComments()
    {
        $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE published = 0 ORDER BY creation_date DESC');
        $statement->execute();
        $unpublishedComments = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $unpublishedComments;
    }

    /**
     * @param mixed $commentId
     * 
     * @return [type]
     */
    public function delete($commentId)
    {
        $statement = $this->getDb()->prepare('DELETE FROM comment WHERE comment_id = :comment_id');
        $statement->execute([
            ':comment_id' => $commentId
        ]);
    }
}
