<?php

namespace App\controller;

use \App\model\BlogpostManager;
use \App\model\GetPostHelper;
use \App\model\BlogpostModel;


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
        //$helper = new GetPostHelper();
        //$message = '';
        $blogpost = $blogpostManager->getPost($post_id);
        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost]);
        return $blogpost;
    }

    public function modify($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        // $blogpost = new BlogpostManager();
        $blogpost = $blogpostManager->getPost($post_id);
        //var_dump($blogpost);

        // $message = '';
        if (null !== ($helper->getPost('updateBlogpost'))) {
            //var_dump($_POST);
            //exit;
            $blogpostModel = new BlogpostModel($_POST);
            //var_dump($blogpostModel);
            //exit;
            $blogpost = $blogpostManager->modify($blogpostModel);
        }


        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost]);
    }

    public function delete($post_id)
    {
        $blogpostManager = new BlogpostManager();
        $helper = new GetPostHelper();
        $blogpost = $blogpostManager->getPost($post_id);
        $postId = 2;
        if (null !== ($helper->getPost('deleteBlogpost'))) {
            //$blogpostModel = new BlogpostModel($_POST);
            $blogpost->delete($postId);
        }
        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost]);
    }
}
