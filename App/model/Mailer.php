<?php

namespace App\model;
require __DIR__.'/../../vendor/autoload.php';


class Mailer
{
 

 public function sendMail($receiver, $subject, $messageBody){
    $transport = (new \Swift_SmtpTransport('localhost', 1025))
        ->setUsername('')
        ->setPassword('');

    // Create the Mailer using your created Transport
    $mailer = new \Swift_Mailer($transport);

    // Create a message
    $message = (new \Swift_Message($subject))
        ->setFrom(['ana.mlkv.92@gmail.com'])
        ->setTo([$receiver])
        ->setBody($messageBody);

    // Send the message
    $result = $mailer->send($message);
 }
       
    
}
