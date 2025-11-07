<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/test', name: 'app_first')]

class Test extends AbstractController
{

    #[Route('/affiche', name: 'test_affiche')]
    public function afficher()
    {
        return new Response("Bonjour 3A58!!!!");
    }
}
