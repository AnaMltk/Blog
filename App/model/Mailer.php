<?php

namespace App\model;
use \App\controller\Session;
require __DIR__.'/../../vendor/autoload.php';


class Mailer
{
 

 public function sendMail($receiver, $subject, $messageBody){
    $ini = parse_ini_file('../../config.ini');
    $username = $ini['smtp_user_name'];
    $password = $ini['smtp_password'];
    $port = $ini['smtp_port'];
    $address = $ini['smtp_address'];
    $session = new Session();
    try{
    $transport = (new \Swift_SmtpTransport($address, $port))
    //$transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465))
        ->setUsername($username)
        ->setPassword($password);

    // Create the Mailer using your created Transport
    $mailer = new \Swift_Mailer($transport);

    // Create a message
    $message = (new \Swift_Message($subject))
        ->setFrom([$username])
        ->setTo([$receiver])
        ->setBody($messageBody);

    // Send the message
    $result = $mailer->send($message);
    $session->write('message', 'Votre message a été envoyé avec success');
    } catch (\Exception $e) {
        $session->write('message', 'Votre message n\'a pas été envoyé');
    }
 }
       
    
}
