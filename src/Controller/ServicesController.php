<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'service_index')]
    public function index(): Response
    {
        return $this->render('services/index.html.twig', [
            'class_name' => '3A78',
        ]);
    }


    #[Route('/show/{name}', name: 'app_services')]
    public function showService($name): Response
    {
        return new Response("<h1> le nom est  </h1>" . $name);
    }

    #[Route('/showHTML/{name}', name: 'app_services_html')]
    public function showServiceView($name): Response
    {
        return $this->render('services\showService.html.twig', [
            'className' => $name,

        ]);
    }


    #[Route('/goToIndex', name: 'service_goto')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('first_afficher');
    }
}
