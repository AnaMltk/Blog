<?php

namespace App\model;


class BlogpostManager extends Manager
{

    public function add($blogpost)
    {

        $blogposts = $this->getDb()->prepare('INSERT INTO blogpost (user_id, title, creation_date, content, headline) VALUES (:user_id, :title, :creationDate, :content, :headline)');

        $blogposts->execute([
            ':user_id' => $blogpost->getUserId(),
            ':title' => $blogpost->getTitle(),
            ':creationDate' => date('Y-m-d H:i:s'),
            ':content' => $blogpost->getContent(),
            ':headline' => $blogpost->getHeadline()
        ]);
    }

    public function modify($blogpost)
    {
        //var_dump($blogpost);
        //exit;
        $statement = $this->getDb()->prepare('UPDATE blogpost SET title = :title, content = :content, headline = :headline WHERE post_id = :post_id');
        $statement->execute([
            ':title' => $blogpost->getTitle(),
            ':content' => $blogpost->getContent(),
            ':headline' => $blogpost->getHeadline(),
            ':post_id' => $blogpost->getPostId(),
        ]);


        return $this->getPost($blogpost->getPostId());
    }

    public function getPost($postId)
    {
        $statement = $this->getDb()->prepare('SELECT * FROM blogpost WHERE post_id = ?');
        $statement->execute(array($postId));
        $blogpost = $statement->fetchObject();
        return $blogpost;
    }

    public function listPosts()
    {
        $statement = $this->getDb()->prepare('SELECT * FROM blogpost ORDER BY creation_date DESC');
        $statement->execute();
        $blogposts = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //var_dump($blogposts);
        return $blogposts;
    }

    public function delete($postId)
    {
        $statement = $this->getDb()->prepare('DELETE * FROM blogpost WHERE post_id = ?');
        $statement->execute(array($postId));
    }
}
