<?php

namespace App\model;


class BlogpostManager extends Manager
{

    /**
     * @param BlogpostModel $blogpost
     * 
     * @return string
     */
    public function add(BlogpostModel $blogpost): string
    {
        $blogposts = $this->getDb()->prepare('INSERT INTO blogpost (user_id, author, title, creation_date, content, headline) VALUES (:user_id, :author, :title, :creationDate, :content, :headline)');
        $blogposts->execute([
            ':user_id' => $blogpost->getUserId(),
            ':author' => $blogpost->getAuthor(),
            ':title' => $blogpost->getTitle(),
            ':creationDate' => date('Y-m-d H:i:s'),
            ':content' => $blogpost->getContent(),
            ':headline' => $blogpost->getHeadline()
        ]);
       
        $message = 'L\'article a été créé avec success';
        return $message;
    }


   
    public function modify(BlogpostModel $blogpost)
    {
        $statement = $this->getDb()->prepare('UPDATE blogpost SET title = :title, content = :content, headline = :headline, modification_date = :modificationDate WHERE post_id = :post_id');
        $statement->execute([
            ':title' => $blogpost->getTitle(),
            ':content' => $blogpost->getContent(),
            ':headline' => $blogpost->getHeadline(),
            ':modificationDate' => date('Y-m-d H:i:s'),
            ':post_id' => $blogpost->getPostId(),
        ]);


        return $this->getPost($blogpost->getPostId());
    }

    /**
     * @param int $postId
     * 
     * @return array
     */
    public function getPost(int $postId)
    {
        $blogpostModel = new BlogpostModel();
        $statement = $this->getDb()->prepare('SELECT * FROM blogpost WHERE post_id = ?');
        $statement->execute(array($postId));
        $blogpost = $statement->fetch(\PDO::FETCH_ASSOC);
        $blogpostModel->hydrate($blogpost);

        return $blogpostModel;
    }

    /**
     * @return array
     */
    public function listPosts(): array
    {
        $statement = $this->getDb()->prepare('SELECT * FROM blogpost ORDER BY creation_date DESC');
        $statement->execute();
        $blogposts = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $blogpostList = [];
        foreach ($blogposts as $blogpost) {
            $blogpostModel = new BlogpostModel();
            $blogpostModel->hydrate($blogpost);
            $blogpostList[] = $blogpostModel;
        }
        return $blogpostList;
    }

    /**
     * @param BlogpostModel $blogpost
     * 
     * @return void
     */
    public function delete(BlogpostModel $blogpost): void
    {
        $statement = $this->getDb()->prepare('DELETE FROM blogpost WHERE post_id = :post_id');
        $statement->execute([
            ':post_id' => $blogpost->getPostId(),
        ]);
    }
}
