<?php

namespace App\model;


class BlogpostManager extends Manager
{

    public function add($blogpost)
    {

        $blogposts = $this->getDb()->prepare('INSERT INTO blogpost (user_id, title, creation_date, content, headline) VALUES (:user_id, :title, :creationDate, :content, :headline)');
        
        $blogposts->execute([
            ':user_id'=> $blogpost->getUserId(), 
            ':title' => $blogpost->getTitle(), 
            ':creationDate' => date('Y-m-d H:i:s'), 
            ':content' => $blogpost->getContent(), 
            ':headline' => $blogpost->getHeadline()
            ]);
           
    }

    public function modify($postId, $content)
    {
        $statement = $this->getDb()->prepare('UPDATE blogpost SET content = ? WHERE post_id = ?');
        $blogpost = $statement->execute(array($content, $postId));
        return $blogpost;
    }

    public function getPost($postId)
    {
        $statement = $this->getDb()->prepare('SELECT * FROM blogpost WHERE post_id = ?');
        $statement->execute(array($postId));
        $blogpost = $statement->fetch(\PDO::FETCH_ASSOC);
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
}
