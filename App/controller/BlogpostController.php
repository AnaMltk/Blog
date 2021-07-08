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
        if (1 != $_SESSION['user']['role']) {
            
            $this->view->redirect('/homepage/home');
        }
        $blogpost = new BlogpostManager();
        $helper = new GetPostHelper();
        $message = '';

        if (null !== ($helper->getPost('createBlogpost'))) {

            $blogpostModel = new BlogpostModel($helper->getPost());

            $message = $blogpost->add($blogpostModel);
        }

        //$this->view->display('blogpost/createBlogpost.html.twig', ['message' => $message, 'blogpost' => $blogpost, 'user' => $_SESSION['user']]);
        $this->view->display('blogpost/createBlogpost.html.twig', ['message' => $message, 'blogpost' => $blogpost, 'user' => $session->read('user')]);
    }

    public function listPosts()
    {
        $blogpostManager = new BlogpostManager();
        $session = new Session();

        $blogposts = $blogpostManager->listPosts();

        //$this->view->display('blogpost/blogpostList.html.twig', ['blogposts' => $blogposts, 'user' => $_SESSION['user'] ??'']);
        $this->view->display('blogpost/blogpostList.html.twig', ['blogposts' => $blogposts, 'user' => $session('user') ??'']);
    }

    public function getPost($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $commentManager = new CommentManager();

        $helper = new GetPostHelper();
        $comments = $commentManager->listComments($post_id);
        $blogpost = $blogpostManager->getPost($post_id);
        if(empty($blogpost)){
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
        if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $_SESSION['message'] = '';
        }
        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost ?? '', 'comments' => $comments, 'user' => $_SESSION['user'] ?? '', 'message' => $message]);
        return $blogpost;
    }

    public function modify($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        // $blogpost = new BlogpostManager();
        $blogpost = $blogpostManager->getPost($post_id);


        // $message = '';
        if (null !== ($helper->getPost('updateBlogpost'))) {

            $blogpostModel = new BlogpostModel($helper->getPost());

            $blogpost = $blogpostManager->modify($blogpostModel);
        }


        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost, 'user' => $_SESSION['user']]);
    }

    public function delete($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        //$blogpost = $blogpostManager->getPost($post_id);
        $message = '';
        //$postId = 2;
        if (null !== ($helper->getPost('deleteBlogpost'))) {
            $blogpostModel = new BlogpostModel($helper->getPost());
            $message = $blogpostManager->delete($blogpostModel);
            //$message = $blogpostManager->delete($blogpostModel);
            // var_dump($message);
        }
        $this->view->display('blogpost/blogpostView.html.twig', ['message' => $message, 'user' => $_SESSION['user']]);
        //header('Location: /?action=blogpost/listPosts');
    }
}
