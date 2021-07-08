<?php

namespace App\controller;

use \App\model\UserManager;
use \App\model\Mailer;
use \App\model\GetPostHelper;
use \App\model\UserModel;


class UserController extends AppController
{

    public function add()
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $userModel = new UserModel();
        $session = new Session();
        $message = '';


        if (null !== ($helper->getPost('register'))) {
            //if ($helper->getPost('CSRFToken') == $_SESSION['token']) {
                if($helper->getPost('CSRFToken')== $session->read('token')){
                $userModel = new UserModel($helper->getPost());
                $message = $user->add($userModel);
            }
        }
        $session->write('token', $this->getToken());
        //$_SESSION['token'] = $this->getToken();
        //redirect user on homepage

        $this->view->display('user/registration.html.twig', ['message' => $message, 'user' => $user, 'token' =>$session->read('token')]);
    }

    public function getUser($userId)
    {
        $userManager = new UserManager();

        //$helper = new GetPostHelper();

        $user = $userManager->getUser($userId);

        //$userModel = new UserManager();
        //$this->view->display('user/userView.html.twig', ['user' => $user]);
        return $user;
    }

    public function logIn()
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $error = '';
        $userData = $helper->getPost();
        //var_dump($userData); 

        if (!empty($userData)) {
            $login = $userData['username'];
            $password = $userData['password'];


            if ($user_id = $user->logIn($login, $password)) {

                $_SESSION['user'] = $this->getUser($user_id);

                $this->view->redirect('/homepage/home');
            }
            $error = 'Wrong email or password, please try again';
        }
        // $error = 'wrong password';


        $this->view->display('user/login.html.twig', ['error' => $error]);
    }

    public function logOut()
    {
        $helper = new GetPostHelper();
        $session = new Session();
        //if (null !== ($helper->getPost('logout'))) {
        //$_SESSION = array();
        $session->delete();
        //}
        //$this->view->display('homepage.html.twig', ['user' => $_SESSION['user'] ?? '']);
        $this->view->redirect('/homepage/home');
        //header('Location: /user/listUsers');
    }

    public function listUsers()
    {
        $userModel = new UserManager();
        $session = new Session();
        $users = $userModel->listUsers();

        //$this->view->display('user/userslist.html.twig', ['users' => $users, 'user' => $_SESSION['user'] ?? '']);
        $this->view->display('user/userslist.html.twig', ['users' => $users, 'user' => $session->read('user') ?? '']);
    }

    public function resetPassword()
    {
        $helper = new GetPostHelper();
        $user = new UserManager();
        $mailer = new Mailer();
        $token = '';
        $subject = 'Reset your password';
        $messageBody = 'Please follow this link to reset your password : ';
        if (null !== ($helper->getPost('submit'))) {

            $userModel = new UserModel($helper->getPost());
            $token = $user->getTokenForPasswordReset($userModel->getUserEmail());
            $url = 'blog/user/modifyPassword/' . $token;
            $messageBody = $messageBody . ' ' . $url;
            $mailer->sendMail($userModel->getUserEmail(), $subject, $messageBody);
            //header('Location: modifyPassword/'.$token);

        }

        $this->view->display('user/resetPassword.html.twig', []);
    }

    public function modifyPassword($token)
    {
        $helper = new GetPostHelper();
        $userManager = new UserManager();


        if (null !== ($helper->getPost('submit'))) {

            $userManager->modifyPassword($helper->getPost('password'), $token);
        }

        $this->view->display('user/newPassword.html.twig', ['token' => $token]);
    }

    /* public function sendMail(){
        $mailer = new Mailer();
        $mailer->sendMail();
        
        header('Location: /user/listUsers');
    }*/
}
