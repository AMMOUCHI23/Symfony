<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        $session= $request->getSession();
        if (!$session->has(name:'todos')) {
            $todos=[
                'ahat'=>'acheter clé USB',
                'cours'=>'finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos', $todos);   
            $this->addFlash(type:'info',message:'La liste des todos vient d\'etre initialisée');
        }
        
        return $this->render('todo/index.html.twig', [
            
        ]);
    }
        #[Route('/todo/add/{name}/{content}', name: 'todo.add',methods:'GET')]
        public function addTodo(Request $request,$name,$content): Response
        {
            $session= $request->getSession();
   
    
     if ($session->has(name:'todos')) {
       
     if (isset($todos[$name])){
        $this->addFlash(type:'error',message:"Le todo d'id $name éxiste déjà dans la liste");   
     
    }
     else { 
         $todos[$name] = $content;
         $this->addFlash(type:'success',message:"Le todo d'id $name a eté ajoter avec succée");
         $session->set('todos',$todos);
        }
     
     }
    else {
        $this->addFlash(type:'info',message:'La liste des todos  n\'pas encore initialisée');
    }
    return $this->redirectToRoute('todo');
}
}