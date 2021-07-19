<?php

namespace App\controller;

use \App\model\UserManager;
use \App\service\Mailer;
use \App\model\GetPostHelper;
use \App\model\UserModel;


class UserController extends AppController
{

    public function index()
    {
        $this->view->redirect('/homepage/home');
    }

    /**
     * @return void
     */
    public function add(): void
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $userModel = new UserModel();
        $session = new Session();
        $message = '';


        if (null !== ($helper->getPost('register'))) {

            if ($helper->getPost('token') == $session->read('token')) {
                $userModel = new UserModel($helper->getPost());
                $message = $user->add($userModel);
            }
        }
        $session->write('token', $this->getToken());

        $this->view->display('user/registration.html.twig', ['message' => $message, 'user' => $user, 'token' => $session->read('token')]);
    }


    /**
     * @param int $userId
     * 
     * @return array
     */
    public function getUser(int $userId): array
    {
        $userManager = new UserManager();

        $user = $userManager->getUser($userId);

        return $user;
    }

    /**
     * @return void
     */
    public function logIn(): void
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $session = new Session();
        $error = '';
        $userData = $helper->getPost();

        if ($helper->getPost('token') == $session->read('token')) {
            if (!empty($userData)) {
                $login = $userData['username'];
                $password = $userData['password'];


                if ($user_id = $user->logIn($login, $password)) {

                    $session->write('user', $this->getUser($user_id));

                    $this->view->redirect('/homepage/home');
                }

                $error = 'Votre email ou mot de passe sont erronés, veuillez réessayer';
            }
        }

        $session->write('token', $this->getToken());

        $this->view->display('user/login.html.twig', ['error' => $error, 'token' => $session->read('token')]);
    }

    /**
     * @return void
     */
    public function logOut(): void
    {
        $session = new Session();

        $session->delete();

        $this->view->redirect('/homepage/home');
    }

    /**
     * @return void
     */
    public function listUsers(): void
    {
        $userModel = new UserManager();
        $session = new Session();
        $users = $userModel->listUsers();

        $this->view->display('user/userslist.html.twig', ['users' => $users, 'user' => $session->read('user') ?? '']);
    }

    /**
     * @return void
     */
    public function resetPassword(): void
    {
        $helper = new GetPostHelper();
        $user = new UserManager();
        $session = new Session();
        $mailer = new Mailer();
        $token = '';
        $message = '';
        $subject = 'Réinitialisez votre mot de passe';
        $messageBody = 'Cliquez sur ce lien pour modifier votre mot de passe : ';
        if (null !== ($helper->getPost('submit'))) {
            if ($helper->getPost('token') == $session->read('token')) {
                $userModel = new UserModel($helper->getPost());
                $token = $user->getTokenForPasswordReset($userModel->getUserEmail());
                if (null != $token) {
                    $url = 'blog/user/modifyPassword/' . $token;
                    $messageBody = $messageBody . ' ' . $url;
                    $mailer->sendMail($userModel->getUserEmail(), $subject, $messageBody);
                } else {
                    $message = 'Le compte avec cet email n\'existe pas';
                }
            }
        }

        if (null !== $session->read('message') && !empty($session->read('message'))) {
            $message = $session->read('message');
            $session->write('message', '');
        }
        $session->write('token', $this->getToken());
        $this->view->display('user/resetPassword.html.twig', ['token' => $session->read('token'), 'message' => $message]);
    }

    /**
     * @param string $token
     * 
     * @return void
     */
    public function modifyPassword(string $token): void
    {
        $helper = new GetPostHelper();
        $userManager = new UserManager();
        $session = new Session();
        $message = '';
        if (null !== ($helper->getPost('submit'))) {
            if ($helper->getPost('token') == $session->read('token')) {
                $message = $userManager->modifyPassword($helper->getPost('password'), $token);
            }
        }
        $session->write('token', $this->getToken());
        if (null !== $session->read('message') && !empty($session->read('message'))) {
            $message = $session->read('message');
            $session->write('message', '');
        }
        $this->view->display('user/newPassword.html.twig', ['token' => $session->read('token'), 'message' => $message]);
    }
}
