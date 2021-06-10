<?php

namespace App\controller;

use \App\model\BlogpostManager;
use \App\model\GetPostHelper;
use \App\model\BlogpostModel;
use App\model\CommentManager;

class BlogpostController extends AppController
{

    public function add()
    {
        $blogpost = new BlogpostManager();
        $helper = new GetPostHelper();
        $message = '';

        if (null !== ($helper->getPost('createBlogpost'))) {

            $blogpostModel = new BlogpostModel($_POST);

            $message = $blogpost->add($blogpostModel);
        } else {
            echo 'please enter all information';
        }

        $this->view->display('blogpost/createBlogpost.html.twig', ['message' => $message, 'blogpost' => $blogpost]);
    }

    public function listPosts()
    {
        $blogpostManager = new BlogpostManager();
        $blogposts = $blogpostManager->listPosts();
        $this->view->display('blogpost/blogpostList.html.twig', ['blogposts' => $blogposts]);
    }

    public function getPost($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $commentManager = new CommentManager();
        $comments = $commentManager->listComments($post_id);
        //$helper = new GetPostHelper();
        //$message = '';
        $blogpost = $blogpostManager->getPost($post_id);
        var_dump($_SESSION['user']);
        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost, 'comments' => $comments, 'user'=>$_SESSION['user'] ?? '']);
        return $blogpost;
    }

    public function modify($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        // $blogpost = new BlogpostManager();
        $blogpost = $blogpostManager->getPost($post_id);
        var_dump($blogpost);

        // $message = '';
        if (null !== ($helper->getPost('updateBlogpost'))) {

            $blogpostModel = new BlogpostModel($_POST);
            var_dump($blogpostModel);
            $blogpost = $blogpostManager->modify($blogpostModel);
            var_dump($blogpost);
        }


        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost]);
    }

    public function delete($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        $blogpost = $blogpostManager->getPost($post_id);
        var_dump($blogpost);
        $message = '';
        //$postId = 2;
        if (null !== ($helper->getPost('deleteBlogpost'))) {
            $blogpostModel = new BlogpostModel($_POST);
            var_dump($blogpostModel);
            $message = $blogpostManager->delete($blogpostModel);
            //$message = $blogpostManager->delete($blogpostModel);
            // var_dump($message);
        }
        $this->view->display('blogpost/blogpostView.html.twig', ['message' => $message]);
        //header('Location: /?action=blogpost/listPosts');
    }
}
