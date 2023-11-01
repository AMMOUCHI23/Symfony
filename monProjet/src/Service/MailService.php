<?php
namespace App\Service;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class MailService {
    private MailerInterface $mailer;

    //On injecte dans le constructeur le MailerInterface

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
}
public function sendMail($expediteur, $destinataire, $sujet, $message,$htmlTemplate,$context){

    $email = (new TemplatedEmail ())
    ->from($expediteur)
    ->to($destinataire)
    ->subject($sujet)
    ->text($message)
    ->htmlTemplate($htmlTemplate)
    ->context ($context);
$this->mailer->send($email);
}
}