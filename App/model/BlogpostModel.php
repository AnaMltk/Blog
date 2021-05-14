<?php

namespace App\model;


class BlogpostModel extends Model
{


    protected $userId;
    protected $postId;
    protected $creationDate;
    protected $modificationDate;
    protected $title;
    protected $content;
    protected $headline;

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPostID()
    {
        return $this->postId;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getHeadline()
    {
        return $this->headline;
    }

    public function getContent()
    {
        return $this->content;
    }


    public function setCreationDate($creationDate)
    {

        $this->creationDate = $creationDate;
    }
    public function setModificationDate($modificationDate)
    {

        $this->modificationDate = $modificationDate;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }
}
