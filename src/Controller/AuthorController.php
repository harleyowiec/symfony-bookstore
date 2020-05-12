<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\Type\AuthorType;
use App\Services\AuthorService;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @var
     */
    private $authorService;

    /**
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }
    /**
     * @Route("/authors", name="authors_index")
     */
    public function index(): Response
    {
        $authors = $this->authorService->getAuthors();

        return $this->render('author/index.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/authors/create", name="authors_create")
     * @param Request $request
     * @return Response
     * @throws ORMException
     */
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();
            $this->authorService->save($author);

            return $this->redirectToRoute('authors_index');
        }

        return $this->render('author/create.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/authors/{id}", name="authors_show")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $author = $this->authorService->getById($id);

        return $this->render('author/show.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("/authors/{id}/edit", name="authors_edit")
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ORMException
     */
    public function edit(Request $request, int $id): Response
    {
        $author = $this->authorService->getById($id);
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();
            $this->authorService->save($author);

            return $this->redirectToRoute('authors_index');
        }

        return $this->render('author/create.form.html.twig', [
            'form' => $form->createView(),
            'edit' => true
        ]);
    }

    /**
     * @Route("authors/{id}/delete", name="authors_delete")
     * @param int $id
     * @return RedirectResponse
     * @throws ORMException
     */
    public function delete(int $id): RedirectResponse
    {
        $this->authorService->delete($id);

        return $this->redirectToRoute('authors_index');
    }
}
