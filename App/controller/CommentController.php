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

            $commentModel = new CommentModel($helper->getPost());
           
           $message = $comment->add($commentModel); 
           $_SESSION['message'] = $message;
        }
        //header('Location: /blogpost/getPost/'.$commentModel->getPostId());
        $this->view->redirect('/homepage/home'.$commentModel->getPostId());
        //$this->view->display('blogpost/blogpostView.html.twig', ['message' => $message, 'comment' => $comment]);
    }

}
