<?php
namespace App\Controller;
use App\Entity\Contact;
use App\Service\MailService;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(MailService $mailservice, Request $request, EntityManagerInterface $manager): Response
    { 
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //on crée une instance de Contact
           // $contact = new Contact();
           $contact =$form->getData();
          
            // Traitement des données du formulaire
           // $data = $form->getData();
            //on stocke les données récupérées dans la variable $message
            //$contact = $data;

            $manager->persist($contact);
            $manager->flush();
           
            //Envoie de mail avec le service créer MailService
            $mailservice->sendMail(
                "hello@example.com",
                 $contact->getEmail() ,
                  "Les contact",
                   $contact->getMessage(),
                   'emails/contact_email.html.twig',
                  ['contact' => $contact]
                
               
            );

            /*
            //envoi de mail avec notre service MailService
            $email = $ms->sendMail('hello@example.com', $contact->getEmail(), $contact->getObjet(), $contact->getMessage() );
//            dd($message->getEmail());
           */ 

           /*
            // envoie de l'email par MailerInterface
            $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to($contact->getEmail())
            ->subject('Les contacts')
            ->htmlTemplate('emails/contact_email.html.twig')

            ->context([
                
                $objet = $contact->getObjet(),
                $mail = $contact->getEmail(),
                $demande = $contact->getMessage(),
                'objet' => $objet,
                'mail' =>$mail,
                'message'=> $demande,
                'data' => $data,
            ]);
            */
          
           
        }

        return $this->render('accueil/index.html.twig', [
//            'form' => $form->createView(),
              'form' => $form
        ]);
    }
}
