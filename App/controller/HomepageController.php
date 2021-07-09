<?php

namespace App\controller;


use \App\model\Mailer;
use \App\model\GetPostHelper;


class HomepageController extends AppController
{

    public function home()
    {
        $session = new Session();
        $error = '';
        $this->view->display('homepage.html.twig', ['error' => $error, 'user' => $session->read('user') ?? '']);
    }

    public function getContactMessage()
    {
        $helper = new GetPostHelper();
        $session = new Session();
        $mailer = new Mailer();
        $subject = 'New message from contact form';
        $message = '';
        if (null !== ($helper->getPost('submit')) && 10 < strlen($helper->getPost('message'))) {
            if ($helper->getPost('token') == $session->read('token')) {
                $messageBody = 'You have a new message ' . $helper->getPost('message');
                $senderEmail = $helper->getPost('email');
                $mailer->sendMail($senderEmail, $subject, $messageBody);
                $session->write('message', 'Votre message a été envoyé avec success');
                //$message = 'Votre message a été envoyé avec success';
            }
        }
        
        if (null !== $session->read('message') && !empty($session->read('message'))) {
            $message = $session->read('message');
            $session->write('message', '');
        }
        $session->write('token', $this->getToken());
        $this->view->display('homepage.html.twig', ['user' => $session->read('user') ?? '', 'message'=> $message, 'token' => $session->read('token')]);
    }
}
