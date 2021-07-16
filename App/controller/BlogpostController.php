<?php

namespace App\controller;

use \App\model\BlogpostManager;
use \App\model\GetPostHelper;
use \App\model\BlogpostModel;
use App\model\CommentManager;
use App\model\CommentModel;

class BlogpostController extends AppController
{

    public function add()
    {
        $session = new Session();
        $userInformation = $session->read('user');
        $userRole = $userInformation['role'];

        if (1 != $userRole) {

            $this->view->redirect('/homepage/home');
        }
        $blogpost = new BlogpostManager();
        $helper = new GetPostHelper();
        $message = '';

        if (null !== ($helper->getPost('createBlogpost'))) {
            if ($helper->getPost('token') == $session->read('token')) {
                $blogpostModel = new BlogpostModel($helper->getPost());

                $message = $blogpost->add($blogpostModel);
            }
        }
        $session->write('token', $this->getToken());
        
        $this->view->display('blogpost/createBlogpost.html.twig', ['message' => $message, 'blogpost' => $blogpost, 'user' => $userInformation, 'token' => $session->read('token'), 'commentToken' => $session->read('commentToken')]);
    }

    public function listPosts()
    {
        $blogpostManager = new BlogpostManager();
        $session = new Session();

        $blogposts = $blogpostManager->listPosts();

        $this->view->display('blogpost/blogpostList.html.twig', ['blogposts' => $blogposts, 'user' => $session->read('user') ?? '']);
    }

    public function getPost($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $commentManager = new CommentManager();
        $session = new Session();
        $helper = new GetPostHelper();
       
        $comments = $commentManager->listComments($post_id);
        
        $blogpost = $blogpostManager->getPost($post_id);
        if (empty($blogpost)) {
            $this->view->redirect('/homepage/home');
        }

        if (null !== ($helper->getPost('publish'))) {
            $commentModel = new CommentModel($helper->getPost());
            $commentManager->publish($commentModel->getCommentId());
            $comments = $commentManager->listComments($post_id);
        }

        if (null !== ($helper->getPost('delete'))) {
            $commentModel = new CommentModel($helper->getPost());
            $commentManager->delete($commentModel->getCommentId());
            $comments = $commentManager->listComments($post_id);
        }
        $message = '';
        if (null !== $session->read('message') && !empty($session->read('message'))) {
            $message = $session->read('message');
            $session->write('message', '');
        }
        
        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost ?? '', 'comments' => $comments, 'user' => $session->read('user') ?? '', 'message' => $message]);
        return $blogpost;
    }

    public function modify($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        $session = new Session();
        $userInformation = $session->read('user');
        $userRole = $userInformation['role'];

        if (1 != $userRole) {

            $this->view->redirect('/homepage/home');
        }
       
        $blogpost = $blogpostManager->getPost($post_id);

        if (null !== ($helper->getPost('updateBlogpost'))) {
            if ($helper->getPost('token') == $session->read('token')) {
                $blogpostModel = new BlogpostModel($helper->getPost());

                $blogpost = $blogpostManager->modify($blogpostModel);
            }
        }

        $session->write('token', $this->getToken());
        $this->view->display('blogpost/blogpostUpdate.html.twig', ['blogpost' => $blogpost, 'user' => $session->read('user'), 'token' => $session->read('token')]);
    }

    public function delete()
    {
        $session = new Session();
        $userInformation = $session->read('user');
        $userRole = $userInformation['role'];

        if (1 != $userRole) {

            $this->view->redirect('/homepage/home');
        }
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        if (null !== ($helper->getPost('deleteBlogpost'))) {
            $blogpostModel = new BlogpostModel($helper->getPost());
            $blogpostManager->delete($blogpostModel);
        }
        $this->view->redirect('/adminpage/admin');
    }
}
