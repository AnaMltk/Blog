<?php

namespace App\model;


class BlogpostManager extends Manager
{

    public function add($blogpost)
    {

        $blogposts = $this->getDb()->prepare('INSERT INTO blogpost (title, creation_date, modification_date, content, headline) VALUES (:title, :creationDate, :modificationDate, :content, :headline)');

        $blogposts->execute([':title' => $blogpost->getTitle(), ':creationDate' => $blogpost->getCreationDate(), ':modificationDate' => $blogpost->getModificationDate(), ':content' => $blogpost->getContent(), ':headline' => $blogpost->getHeadline()]);
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
        return $blogposts;
    }

}
