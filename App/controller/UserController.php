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
           
            if ($helper->getPost('token') == $session->read('token')) {
                $userModel = new UserModel($helper->getPost());
                $message = $user->add($userModel);
            }
        }
        $session->write('token', $this->getToken());
    
        $this->view->display('user/registration.html.twig', ['message' =>$message, 'user' => $user, 'token' => $session->read('token')]);
    }

    public function getUser($userId)
    {
        $userManager = new UserManager();

        $user = $userManager->getUser($userId);

        return $user;
    }

    public function logIn()
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $session = new Session();
        $error = '';
        $userData = $helper->getPost();
        
        if($helper->getPost('token')== $session->read('token')){
        if (!empty($userData)) {
            $login = $userData['username'];
            $password = $userData['password'];


            if ($user_id = $user->logIn($login, $password)) {

                $session->write('user',$this->getUser($user_id));

                $this->view->redirect('/homepage/home');
            }

            $error = 'Wrong email or password, please try again';
        }
         }
        
        $session->write('token', $this->getToken());

        $this->view->display('user/login.html.twig', ['error' => $error, 'token'=>$session->read('token')]);
    }

    public function logOut()
    {
        $session = new Session();
       
        $session->delete();
      
        $this->view->redirect('/homepage/home');
    
    }

    public function listUsers()
    {
        $userModel = new UserManager();
        $session = new Session();
        $users = $userModel->listUsers();

        $this->view->display('user/userslist.html.twig', ['users' => $users, 'user' => $session->read('user') ?? '']);
    }

    public function resetPassword()
    {
        $helper = new GetPostHelper();
        $user = new UserManager();
        $session = new Session();
        $mailer = new Mailer();
        $token = '';
        $subject = 'Reset your password';
        $messageBody = 'Please follow this link to reset your password : ';
        if (null !== ($helper->getPost('submit'))) {
            if ($helper->getPost('token') == $session->read('token')) {
                $userModel = new UserModel($helper->getPost());
                $token = $user->getTokenForPasswordReset($userModel->getUserEmail());
                $url = 'blog/user/modifyPassword/' . $token;
                $messageBody = $messageBody . ' ' . $url;
                $mailer->sendMail($userModel->getUserEmail(), $subject, $messageBody);

            }
        }
        $session->write('token', $this->getToken());
        $this->view->display('user/resetPassword.html.twig', ['token' => $session->read('token')]);
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

}
