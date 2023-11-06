<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class IngredientController extends AbstractController
{ 
    #[Route('/liste', name: 'app_liste')]
    public function index(IngredientRepository $reposotory, PaginatorInterface $paginator, Request $request): Response
    {
        
            // utiliser la pagination
        $ingredients = $paginator->paginate(
            $reposotory->findAll(),
            $request -> query ->getInt('page', 1),
            5
        );
        
        return $this->render('ingredient/liste.html.twig', [
            'ingredients' => $ingredients
        ]);
    }
    
    // fonction pour creer un ingredient
    #[Route('/ingredient', name: 'ingredient.new', methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $ingredient=new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $ingredient=$form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            // afficher un message  si le formulaire est ajouté
            $this->addFlash(
                'success',
                'l\'ingrédient est bient ajouté'
            );

            // redirection vers une autre page
            return $this->redirectToRoute('app_liste');
        }

        return $this->render('ingredient/index.html.twig', [
            
            'form'=>$form
        ]);
    }

    // Fonction pour modifier un ingrédient
    #[Route('/ingredient/edition/{id}', name: 'ingredient.edit', methods:['GET','POST'])]
    public function edit( Request $request, Ingredient $ingredient, EntityManagerInterface $manager): Response
    {
        
        $form = $this->createForm(IngredientType::class, $ingredient); 
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $ingredients=$form->getData();
            $manager->persist($ingredients);
            $manager->flush();

            // afficher un message  si le formulaire est ajouté
            $this->addFlash(
                'success',
                'l\'ingrédient à eté modifier avec sucès'
            );

            // redirection vers une autre page
            //return $this->redirectToRoute('app_disc');
        }

        return $this->render('ingredient/edit.html.twig', [
            'form'=>$form
          
        ]);
    }

      // Fonction pour supprimer un ingrédient
      #[Route('/ingredient/suppression/{id}', name: 'ingredient.sup', methods:['GET','POST'])]
      public function delet( EntityManagerInterface $manager, Ingredient $ingredient): Response
      {
          $manager->remove ($ingredient);
           $manager->flush();
           if (!$ingredient){
            $this->addFlash(
                'success',
                'l\'ingrédient que vous cherchez n\'existe pas'
            );
            return $this->redirectToRoute('app_liste');
            
           }
  
              // afficher un message  si le formulaire est ajouté
              $this->addFlash(
                  'success',
                  'l\'ingrédient à eté supprimé avec succès'
              );
  
              // redirection vers une autre page
              return $this->redirectToRoute('app_liste');
          
  
      }
 
}
