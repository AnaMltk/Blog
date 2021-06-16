<?php

namespace App\model;


class CommentModel extends Model
{

    protected $comment_id;
    protected $user_id;
    protected $post_id;
    protected $creation_date;
    protected $content;

    public function getCommentId()
    {
        return $this->comment_id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setCommentId($comment_id)
    {
        $this->comment_id = $comment_id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }
    public function setCreationDate($creation_date)
    {

        $this->creation_date = $creation_date;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
