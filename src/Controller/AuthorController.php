<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\Type\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors", name="authors_index")
     */
    public function index(): Response
    {
        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/authors/create", name="authors_create")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

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
        $author = $this->getDoctrine()
            ->getRepository(Author::class)
            ->find($id);

        return $this->render('author/show.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("/authors/{id}/edit", name="authors_edit")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id): Response
    {
        $author = $this->getDoctrine()
            ->getRepository(Author::class)
            ->find($id);

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

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
     */
    public function delete(int $id): RedirectResponse
    {
        $author = $this->getDoctrine()
            ->getRepository(Author::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute('authors_index');
    }
}
