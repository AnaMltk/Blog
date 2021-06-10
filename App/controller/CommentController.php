<?php

namespace App\controller;

use \App\model\BlogpostManager;
use \App\model\GetPostHelper;
use \App\model\BlogpostModel;
use \App\model\CommentModel;
use \App\model\CommentManager;


class CommentController extends AppController
{

    public function add()
    {
        $comment = new CommentManager();
        $helper = new GetPostHelper();
        $message = '';

        if (null !== ($helper->getPost('createComment'))) {

            $commentModel = new CommentModel($_POST);

            $comment->add($commentModel);
        }
        header('Location: /blogpost/getPost/'.$commentModel->getPostId());
        //$this->view->display('blogpost/blogpostView.html.twig', ['message' => $message, 'comment' => $comment]);
    }

    /*public function delete($comment_id)
    {
        $commentManager = new CommentManager();
        $helper = new GetPostHelper();
        $comment = $commentManager->getComment($comment_id);
        $message = '';
        //$postId = 2;
        if (null !== ($helper->getPost('deleteComment'))) {
            $commentModel = new CommentModel($_POST);
            $comment = $commentManager->delete($commentModel);
           
        }
        $this->view->display('blogpost/blogpostView.html.twig', ['comment' => $comment]);
    }*/

    public function listComments()
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->listComments(3);
        $this->view->display('blogpost/blogpostList.html.twig', ['comments' => $comments]);
    }
}
