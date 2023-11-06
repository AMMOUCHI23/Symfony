<?php

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Email;

class MailService {
    private $mailer;

    //On injecte dans le constructeur le MailerInterface

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
}
public function sendMail($expediteur, $destinataire, $sujet, $message){

    $email = (new Email())
    ->from($expediteur)
    ->to($destinataire)
    ->subject($sujet)
    ->text($message);

$this->mailer->send($email);
}
}