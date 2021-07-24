<?php

namespace App\model;


class CommentManager extends Manager
{

    /**
     * @param CommentModel $comment
     * 
     * @return string
     */
    public function add(CommentModel $comment): string
    {
    
        $comments = $this->getDb()->prepare('INSERT INTO comment (user_id, author, post_id, creation_date, content) VALUES (:user_id, :author, :post_id, :creationDate, :content)');

        $comments->execute([
            ':user_id' => $comment->getUserId(),
            ':author' => $comment->getAuthor(),
            ':post_id' => $comment->getPostId(),
            ':creationDate' => date('Y-m-d H:i:s'),
            ':content' => $comment->getContent()
        ]);
        $message = 'Votre commentaire sera publié après la validation par Admin';
       
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
     * @param int $commentId
     * 
     * @return CommentModel
     */
    public function getComment(int $commentId): CommentModel
    {
        $commentModel = new CommentModel();
        $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE comment_id = ?');
        $statement->execute(array($commentId));
        $comment = $statement->fetch(\PDO::FETCH_ASSOC);
        $commentModel->hydrate($comment);
        return $commentModel;
    }

    /**
     * @param int $postId
     * 
     * @return array
     */
    public function listComments(int $postId): array
    {
        $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE post_id = ? AND published = 1 ORDER BY creation_date DESC');
        $statement->execute(array($postId));
        $comments = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $commentList = [];
        foreach ($comments as $comment) {
            $commentModel = new CommentModel();
            $commentModel->hydrate($comment);
            $commentList[] = $commentModel;
        }
        return $commentList;
    }

    /**
     * @return array
     */
    public function listUnpublishedComments(): array
    {
        $statement = $this->getDb()->prepare('SELECT * FROM comment WHERE published = 0 ORDER BY creation_date DESC');
        $statement->execute();
        $unpublishedComments = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $unpublishedCommentList = [];
        foreach($unpublishedComments as $comment){
            $commentModel = new CommentModel();
            $commentModel->hydrate($comment);
            $unpublishedCommentList[] = $commentModel;
        }
        return $unpublishedCommentList;
    }

    /**
     * @param int $commentId
     * 
     * @return void
     */
    public function delete(int $commentId): void
    {
        $statement = $this->getDb()->prepare('DELETE FROM comment WHERE comment_id = :comment_id');
        $statement->execute([
            ':comment_id' => $commentId
        ]);
    }
}
