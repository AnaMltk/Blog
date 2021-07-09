<?php

namespace App\controller;

use \App\model\UserManager;
use \App\model\BlogpostManager;
use \App\model\CommentManager;
use \App\model\Mailer;
use \App\model\GetPostHelper;
use \App\model\UserModel;
use \App\model\CommentModel;

class AdminpageController extends AppController
{

    public function admin()
    {
        $session = new Session();

        if (1 != $_SESSION['user']['role']) {
            $this->view->redirect('/homepage/home');
        }
        $blogpostManager = new BlogpostManager();
        $blogposts = $blogpostManager->listPosts();
        
        $commentManager = new CommentManager();
        $helper = new GetPostHelper();
        $commentModel = new CommentManager();
        $unpublishedComments = $commentManager->listUnpublishedComments();
        if (null !== ($helper->getPost('publish'))) {
            $commentModel = new CommentModel($helper->getPost());
            $commentManager->publish($commentModel->getCommentId());
            $unpublishedComments = $commentManager->listUnpublishedComments();
        }

        if (null !== ($helper->getPost('delete'))) {
            $commentModel = new CommentModel($helper->getPost());
            $commentManager->delete($commentModel->getCommentId());
            $unpublishedComments = $commentManager->listUnpublishedComments();
        }

        
        $error = '';
        $this->view->display('user/admin.html.twig', ['error' => $error, 'comments' => $unpublishedComments, 'blogposts'=>$blogposts, 'user' => $session->read('user') ?? '']);
    }
}
