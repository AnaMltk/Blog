<?php

namespace App\model;


class CommentModel extends Model
{

    protected $comment_id;
    protected $user_id;
    protected $author;
    protected $post_id;
    protected $creation_date;
    protected $content;
    protected $published;

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->comment_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getPublished(): int
    {
        return $this->published;
    }

    /**
     * @param int $comment_id
     * 
     * @return void
     */
    public function setCommentId(int $comment_id): void
    {
        $this->comment_id = $comment_id;
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
     * @param string $author
     * 
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @param int $post_id
     * 
     * @return void
     */
    public function setPostId($post_id): void
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
     * @param string $content
     * 
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param int $publlshed
     * 
     * @return void
     */
    public function setPublished(int $published): void
    {
        $this->published = $published;
    }
}
