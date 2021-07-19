<?php

namespace App\controller;


use \App\service\Mailer;
use \App\model\GetPostHelper;


class HomepageController extends AppController
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
    public function home(): void
    {
        $session = new Session();
        $error = '';
        $this->view->display('homepage.html.twig', ['error' => $error, 'user' => $session->read('user') ?? '']);
    }

    /**
     * @return void
     */
    public function getContactMessage(): void
    {
        $helper = new GetPostHelper();
        $session = new Session();
        $mailer = new Mailer();
        $subject = 'Vous avez un nouveau message envoyé par ' . $helper->getPost('name');
        $message = '';
        if (null !== ($helper->getPost('submit'))) {
            if (10 < strlen($helper->getPost('message'))) {
                if ($helper->getPost('token') == $session->read('token')) {
                    $messageBody = $helper->getPost('message');
                    $senderEmail = $helper->getPost('email');
                    $mailer->sendMail($senderEmail, $subject, $messageBody);
                } else {
                    $session->write('message', 'Votre message n\'a pas été envoyé');
                }
            } else {
                $session->write('message', 'Votre message doit contenir au moins 10 caractères');
            }
        }

        if (null !== $session->read('message') && !empty($session->read('message'))) {
            $message = $session->read('message');
            $session->write('message', '');
        }
        $session->write('token', $this->getToken());
        $this->view->display('homepage.html.twig', ['user' => $session->read('user') ?? '', 'message' => $message, 'token' => $session->read('token')]);
    }
}
