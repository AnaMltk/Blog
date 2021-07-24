<?php

namespace App\controller;

use \App\model\UserManager;
use \App\service\Mailer;
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

                $password = \password_hash($userModel->getUserPassword(), PASSWORD_BCRYPT);
                $userModel->setUserPassword($password);
                $message = [];
                if (!filter_var($userModel->getUserEmail(), FILTER_VALIDATE_EMAIL)) {

                    $message[] = 'Veuillez utiliser l\'email valide';
                }
                if (!preg_match("/[A-Za-z0-9]+/", $userModel->getUserName())) {

                    $message[] = 'Veuillez utiliser un pseudo composé uniquement des lettres et chiffres';
                }
                $existantEmail = $user->getExistingEmail($userModel);
               
                if (!empty($existantEmail)) {
                    $message[] = 'Cet email est déjà utilisé';
                }
                if (empty($message)) {
                    $user->add($userModel);
                    $message[] = 'Votre compte a été créé avec sucess';
                }
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
    public function getUser(int $userId)
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

                $credentials = $user->getCredentials($login);
                if (!$credentials) {
                    $error = 'Votre email est erroné';
                }

                $checkPassword = password_verify($password, $credentials['user_password']);
                if (!$checkPassword) {
                    $error = 'Votre mot de passe est erroné';
                }
                if (password_needs_rehash($password, PASSWORD_BCRYPT)) {
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                }

                if (empty($error) && $user_id = $user->logIn($credentials['user_id'], $hash)) {

                    $session->write('user', $user->getUser($user_id));
                    $this->view->redirect('/homepage/home');
                }

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
                $existantEmail = $user->getExistingEmail($userModel);
                if (!empty($existantEmail)) {
                    $token = bin2hex(random_bytes(50));
                    $user->getTokenForPasswordReset($token, $userModel->getUserEmail());
                }
              
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
                $password = \password_hash($helper->getPost('password'), PASSWORD_BCRYPT);
                $message = $userManager->modifyPassword($password, $token);
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
