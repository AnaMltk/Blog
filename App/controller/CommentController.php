<?php

namespace App\controller;

use \App\model\BlogpostManager;
use \App\model\GetPostHelper;
use \App\model\BlogpostModel;
use \App\model\CommentModel;
use \App\model\CommentManager;


class CommentController extends AppController
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->view->redirect('/homepage/home');
    }

    /**
     * @return void
     */
    public function add(): void
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
        $this->view->redirect('/blogpost/getPost/' . $commentModel->getPostId());
    }
}
