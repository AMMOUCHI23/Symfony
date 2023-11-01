<?php

namespace App\Controller;

use App\Repository\DiscRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Faker\Factory;

class DiscController extends AbstractController
{
    #[Route('/disc', name: 'app_disc')]
    public function index(DiscRepository $reposotory, PaginatorInterface $paginator, Request $request): Response
    {
        
            // utiliser la pagination
        $discs = $paginator->paginate(
            $reposotory->findAll(),
            $request -> query ->getInt('page', 1),
            5
        );
        
        return $this->render('disc/index.html.twig', [
            'discs' => $discs
        ]);
    }
}
