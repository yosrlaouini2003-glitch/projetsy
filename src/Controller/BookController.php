<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BookType;

final class BookController extends AbstractController
{
    #[Route('/books', name: 'book_list')]
    public function listBooks(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('book/list.html.twig', [
            'booksList' => $books,
        ]);
    }

    #[Route('/bookDetails/{id}', name: 'book_details')]
    public function bookDetails(BookRepository $repository, int $id): Response
    {
        $book = $repository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/addBookForm', name: 'add_book_form')]
    public function addBookForm(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editBookForm/{id}', name: 'edit_book_form')]
    public function editBookForm(Request $request, EntityManagerInterface $em, BookRepository $repo, int $id): Response
    {
        $book = $repo->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteBook/{id}', name: 'delete_book')]
    public function deleteBook(EntityManagerInterface $em, BookRepository $repo, int $id): Response
    {
        $book = $repo->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }

        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('book_list');
    }
}
