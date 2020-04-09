<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function index()
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/book/create", name="create_book")
     */
    public function createBook(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setName('Test Book');
        $book->setPrice(22.54);
        $book->setNumberOfPages(98);
        $book->setYear(2014);

        $entityManager->persist($book);

        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }
}
