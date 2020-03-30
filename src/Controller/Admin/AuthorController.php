<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{

    /**
     * @Route("admin/authors", name="admin_author_list")
     */
    public function authors(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();

        return $this->render('admin/author/authors.html.twig', [
            'authors' => $authors
        ]);
    }


    /**
     * @Route("admin/author/show/{id}", name="admin_author_show")
     */
    public function author(AuthorRepository $authorRepository, $id)
    {
        $author = $authorRepository->find($id);

        return $this->render('admin/author/author.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("admin/author/insert", name="admin_author_insert")
     */
    public function authorInsert(Request $request, EntityManagerInterface $entityManager)
    {
        // Je crée un nouveau author, pour le lier à mon formulaire
        $author = new Author();

        // je crée mon formulaire et le je lie à mon nouveau author
        $formAuthor = $this->createForm(AuthorType::class, $author);

        // je demande à mon formulaire $formAuthor de gérer les données
        // de la requete POST
        $formAuthor->handleRequest($request);

        if ($formAuthor->isSubmitted() && $formAuthor->isValid()){

            // je persiste le book
            $entityManager->persist($author);
            $entityManager->flush();

        }

        return $this->render('admin/author/insert.html.twig', [
            'formAuthor' => $formAuthor->createView()
        ]);
    }

    /**
     * @Route("admin/author/delete/{id}", name="admin_author_delete")
     */
    public function authorDelete(
        AuthorRepository $authorRepository,
        EntityManagerInterface $entityManager,
        $id
    )
    {
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->render('admin/author/delete.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("admin/author/update/{id}", name="admin_author_update")
     */
    public function updateAuthor(
        AuthorRepository $authorRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        $id
    )
    {
        $author = $authorRepository->find($id);

        // je crée mon formulaire et le je lie à mon author selectionné
        $formAuthor = $this->createForm(AuthorType::class, $author);

        // je demande à mon formulaire $formAuthor de gérer les données
        // de la requete POST
        $formAuthor->handleRequest($request);

        if ($formAuthor->isSubmitted() && $formAuthor->isValid()) {

            // je persiste le book
            $entityManager->persist($author);
            $entityManager->flush();

        }
        return $this->render('admin/author/update.html.twig', [
            'formAuthor' => $formAuthor->createView()
        ]);
    }

}
