<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\Type\BookType;
use App\Form\Type\FIlterByAuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="books_index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(FIlterByAuthorType::class);

        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $books = $this->getDoctrine()
                ->getRepository(Book::class)
                ->findByAuthorId($data['author']->getId());

//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($data);
//            $entityManager->flush();

//            return $this->redirectToRoute('books_index');
//            $form->get('value')->setData(94);
        }

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/books/create", name="books_create")
     * @param Request $request
     * @return Response
     */
    public function save(Request $request): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('books_index');
        }

        return $this->render('book/create.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/books/{id}", name="books_show")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/books/{id}/edit", name="books_edit")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('books_index');
        }

        return $this->render('book/create.form.html.twig', [
            'form' => $form->createView(),
            'edit' => true
        ]);
    }

    /**
     * @Route("books/{id}/delete", name="books_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('books_index');
    }
}
