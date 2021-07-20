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

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creation_date;
    }

    /**
     * @return string
     */
    public function getModificationDate(): string
    {
        return $this->modification_date;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getHeadline(): string
    {
        return $this->headline;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param int $user_id
     * 
     * @return void
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param int $post_id
     * 
     * @return void
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @param string $creation_date
     * 
     * @return void
     */
    public function setCreationDate(string $creation_date): void
    {

        $this->creation_date = $creation_date;
    }

    /**
     * @param string $modification_date
     * 
     * @return void
     */
    public function setModificationDate(string $modification_date): void
    {

        $this->modification_date = $modification_date;
    }

    /**
     * @param string $title
     * 
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $content
     * 
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param string $headline
     * 
     * @return void
     */
    public function setHeadline(string $headline): void
    {
        $this->headline = $headline;
    }
}
