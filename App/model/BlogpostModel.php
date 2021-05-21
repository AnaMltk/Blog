<?php

namespace App\model;


class BlogpostModel extends Model
{


    protected $user_id;
    protected $post_id;
    protected $creation_date;
    protected $modification_date;
    protected $title;
    protected $content;
    protected $headline;

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPostID()
    {
        return $this->post_id;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function getModificationDate()
    {
        return $this->modification_date;
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

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function setCreationDate($creation_date)
    {

        $this->creation_date = $creation_date;
    }
    public function setModificationDate($modification_date)
    {

        $this->modification_date = $modification_date;
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
