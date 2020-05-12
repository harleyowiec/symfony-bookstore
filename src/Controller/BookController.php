<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\Type\BookType;
use App\Form\Type\FilterByAuthorType;
use App\Services\BookService;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    /**
     * @var
     */
    private $bookService;

    /**
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * @Route("/books", name="books_index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(FilterByAuthorType::class);
        $books = $this->bookService->getBooks();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $books = $this->bookService->getBy($data);
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
     * @throws ORMException
     */
    public function save(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $this->bookService->save($book);

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
        $book = $this->bookService->getById($id);

        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/books/{id}/edit", name="books_edit")
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ORMException
     */
    public function edit(Request $request, int $id): Response
    {
        $book = $this->bookService->getById($id);
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $this->bookService->save($book);

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
     * @throws ORMException
     */
    public function delete(int $id): RedirectResponse
    {
        $this->bookService->delete($id);

        return $this->redirectToRoute('books_index');
    }
}
