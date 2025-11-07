<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


// #[Route('/first', name: 'app_first')]
final class FirstController extends AbstractController

{



    #[Route('/affiche', name: 'first_afficher')]
    public function afficher()
    {
        return new Response("Bonjour tout le monde, vous êtes arrivés!!!!");
    }


    #[Route('/index', name: 'index_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }
}
