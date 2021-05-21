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
        print_r($_POST);

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
        echo $post_id;
        $blogpostManager = new BlogpostManager();
        $blogpost = $blogpostManager->getPost($post_id);
        $this->view->display('blogpost/blogpostView.html.twig', ['blogpost' => $blogpost]);
    }
}
