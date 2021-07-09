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
        $session = new Session();
        $message = '';

        if (null !== ($helper->getPost('createComment'))) {
            if ($helper->getPost('commentToken') == $session->read('commentToken')) {
            $commentModel = new CommentModel($helper->getPost());
           
           $message = $comment->add($commentModel); 
           $session->write('message', $message);
            }
        }
        $session->write('commentToken', $this->getToken());
        //header('Location: /blogpost/getPost/'.$commentModel->getPostId());
        $this->view->redirect('/blogpost/getPost/'.$commentModel->getPostId());
        //$this->view->display('blogpost/blogpostView.html.twig', ['message' => $message, 'comment' => $comment]);
    }

}
