<?php

namespace App\model;


class CommentModel extends Model
{

    protected $comment_id;
    protected $user_id;
    protected $post_id;
    protected $creation_date;
    protected $content;

    /**
     * @return int
     */
    public function getCommentId():int
    {
        return $this->comment_id;
    }

    /**
     * @return int
     */
    public function getUserId():int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getPostId():int
    {
        return $this->post_id;
    }

    /**
     * @return string
     */
    public function getCreationDate():string
    {
        return $this->creation_date;
    }

    /**
     * @return string
     */
    public function getContent():string
    {
        return $this->content;
    }

    /**
     * @param int $comment_id
     * 
     * @return void
     */
    public function setCommentId(int $comment_id):void
    {
        $this->comment_id = $comment_id;
    }

    /**
     * @param int $user_id
     * 
     * @return void
     */
    public function setUserId(int $user_id):void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param int $post_id
     * 
     * @return void
     */
    public function setPostId(int $post_id):void
    {
        $this->post_id = $post_id;
    }

    /**
     * @param string $creation_date
     * 
     * @return void
     */
    public function setCreationDate(string $creation_date):void
    {

        $this->creation_date = $creation_date;
    }

    /**
     * @param string $content
     * 
     * @return void
     */
    public function setContent(string $content):void
    {
        $this->content = $content;
    }
}
