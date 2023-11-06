<?php

   namespace App\EventSubscriber;

   use App\Entity\Contact;
   use Doctrine\Common\EventSubscriber;
   use Doctrine\ORM\Events;
   use Doctrine\Persistence\Event\LifecycleEventArgs;
   use Symfony\Component\Mailer\MailerInterface;
   use Symfony\Component\Mime\Email;

   class ContactSubscriber implements EventSubscriber
   {
       private $mailer;

       public function __construct(MailerInterface $mailer)
       {
           $this->mailer=$mailer;
       }

       public function getSubscribedEvents()
       {
           //retourne un tableau d'événements (prePersist, postPersist, preUpdate etc...)
           return [
               //événement déclenché après l'insert dans la base de donnée
               Events::postPersist,
           ];
       }

       public function postPersist(LifecycleEventArgs $args)
       {
   //        $args->getObject() nous retourne l'entité concernée par l'événement postPersist
           $entity = $args->getObject();

   //     Vérifier si l'entité est un nouvel objet de type Contact;
   //    Si l'objet persité n'est pas de type Contact, on ne veut pas que le Subscriber se déclenche!
           if ($entity instanceof  \App\Entity\Contact) {

               $objet = $entity->getObjet();
               $message = $entity->getMessage();

               //Si l'objet ou le text du message contiennent le mot "rgpd", le Subscriber enverra un email à l'adresse "admin@velvet.com"
               if (preg_match("/rgpd\b/i", $objet) || preg_match("/rgpd\b/i", $message) ) {
                   //     Envoyer un e-mail à l'admin
                   $email = (new Email())
                       ->from('votre_adresse_email@example.com')
                       ->to('admin@velvet.com')
                       ->subject('Alerte RGPD')
                       ->text("Un nouveau message en rapport avec la loi sur les RGPD vous a été envoyé! L'id du message : " .$entity->getId(). " \n Objet du message : " .$entity->getObjet(). " \n Texte du message : " .$entity->getMessage());

                   $this->mailer->send($email);
               }

           }
       }
   }