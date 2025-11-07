<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AuthorType;

final class AuthorController extends AbstractController
{
    #[Route('/authorsList', name: 'author_list')]
    public function listAuthors(AuthorRepository $repository): Response
    {
        // Récupérer tous les auteurs depuis la base de données
        $authors = $repository->findAll();

        // Calculer le nombre total d'auteurs
        $total = count($authors);

        return $this->render('author/list.html.twig', [
            'authorsList' => $authors,
            'total' => $total,
        ]);
    }

    #[Route('/authorDetails/{id}', name: 'author_details')]
    public function authorDetails(AuthorRepository $repository, int $id): Response
    {
        $author = $repository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/addAuthorForm', name: 'add_author_form')]
    public function addAuthorForm(Request $request, EntityManagerInterface $em): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('author_list');
        }

        return $this->render('author/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editAuthorForm/{id}', name: 'edit_author_form')]
    public function editAuthorForm(Request $request, EntityManagerInterface $em, AuthorRepository $repo, int $id): Response
    {
        $author = $repo->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('author_list');
        }

        return $this->render('author/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteAuthor/{id}', name: 'delete_author')]
    public function deleteAuthor(EntityManagerInterface $em, AuthorRepository $repo, int $id): Response
    {
        $author = $repo->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('author_list');
    }
}
