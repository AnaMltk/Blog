<?php

namespace App\controller;

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
        $commentModel = new CommentModel();

        $message = '';
        if (empty($session->read('user'))) {
            $message = 'Seulement les utilisateurs enregistrés peuvent écrire des commentaires';
            $session->write('message', $message);
            $this->view->redirect('/blogpost/getPost/' . $helper->getPost('post_id'));
        }
        if (null !== ($helper->getPost('createComment'))) {
    
            if ($helper->getPost('commentToken') == $session->read('commentToken')) {
                $commentModel = new CommentModel($helper->getPost());
                $commentModel->setUserId($session->read('user')->getUserId());
                $commentModel->setAuthor($session->read('user')->getUserName());
                $message = $comment->add($commentModel);
                $session->write('message', $message);
            }
        }

        $session->write('commentToken', $this->getToken());
        $this->view->redirect('/blogpost/getPost/' . $helper->getPost('post_id'));
    
    }
}
