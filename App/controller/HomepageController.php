<?php

namespace App\controller;

use \App\model\UserManager;
use \App\model\Mailer;
use \App\model\GetPostHelper;
use \App\model\UserModel;

class HomepageController extends AppController
{

    public function home()
    {
        $error = '';
        $this->view->display('homepage.html.twig', ['error' => $error, 'user' => $_SESSION['user'] ?? '']);
    }

    public function getContactMessage()
    {
        $helper = new GetPostHelper();
        $mailer = new Mailer();
        $subject = 'New message from contact form';

        if (null !== ($helper->getPost('submit'))) {
            $messageBody = 'You have a new message ' . $helper->getPost('message');
            $senderEmail = $helper->getPost('email');

            $mailer->sendMail($senderEmail, $subject, $messageBody);
           
        }
       $this->view->display('homepage.html.twig', ['user' => $_SESSION['user'] ?? '']);
    }
}
