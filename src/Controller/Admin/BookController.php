<?php

// je créé un namespace qui correspond au chemin vers cette classe
// (en gardant en tête que "App" = "src")
// et qui permet à Symfony d'"autoloader" ma classe
// sans que j'ai besoin de faire d'import ou de require à la main
namespace App\Controller\Admin;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// je créé ma classe HomeController et je la nomme de la même manière que mon fichier
class BookController extends AbstractController
{

    /**
     * @Route("admin/books", name="admin_book_list")
     *
     * on utilise l'"autowire" de Symfony pour demander à Symfony
     * d'instancier la classe BookRepository dans la variable $bookRepository.
     * Ca marche pour toutes les classes de Symfony (sauf les entités)
     */
    public function books(BookRepository $bookRepository)
    {

        // récupérer le repository des Books, car c'est la classe Repository
        // qui me permet de sélectionner les livres en bdd
        $books = $bookRepository->findAll();

        //$book = $bookRepository->find(1);

        return $this->render('admin/book/books.html.twig', [
           'books' => $books
        ]);

    }

    /**
     * @Route("admin/book/show/{id}", name="admin_book_show")
     */
    public function book($id, BookRepository $bookRepository)
    {
        $book = $bookRepository->find($id);

        return $this->render('admin/book/book.html.twig', [
            'book' => $book
        ]);
    }


    /**
     * @Route("admin/book/insert", name="admin_book_insert")
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {

        // Pour créer un enregistrement de Book en bdd, j'utilise une instance de l'entité Book
        // Doctrine va faire le lien et transformer mon entité en nouvel enregistrement
        $book = new Book();

        $title = $request->query->get('title');

        // j'utilise les setters de mon entité pour donner les valeurs à chaque propriétés (donc à chaque
        // colonne en BDD)
        $book->setTitle($title);
        $book->setAuthor('JPP');
        $book->setNbPages(200);
        $book->setResume('terif eoirfrnv ieuuirnà');

        // j'utilise l'EntityManager avec la méthode persist pour sauvegarder mon entité (similaire à un commit
        // Attention ça n'enregistre pas encore en BDD
        $entityManager->persist($book);

        // j'utilise la méthode flush pour enregistrer en bdd (execute la requête SQL)
        $entityManager->flush();

        return $this->render('admin/book/insert.html.twig', [
           'book' => $book
        ]);

    }

    /**
     * @Route("admin/book/delete/{id}", name="admin_book_delete")
     */
    public function deleteBook(
        BookRepository $bookRepository,
        EntityManagerInterface $entityManager,
        $id
    )
    {

        // Avant de supprimer un élément en bdd, je récupère cet élément
        // qui sera une entité
        // et je le stocke dans une variable
        $book = $bookRepository->find($id);

        // j'utilise l'entityManager pour supprimer mon entité
        $entityManager->remove($book);

        // je "valide" la suppression en bdd
        $entityManager->flush();

        return $this->render('admin/book/delete.html.twig', [
            'book' => $book
        ]);

    }


    /**
     * @Route("admin/book/update/{id}", name="admin_book_update")
     */
    public function updateBook(
        BookRepository $bookRepository,
        EntityManagerInterface $entityManager,
        $id
    )
    {

        // récupérer un livre en bdd (avec le book repository et un id de livre)
        $book = $bookRepository->find($id);

        // avec l'entité récupérée, on utilise les setters pour modifier les champs qu'on veut modifier
        $book->setTitle('titre modifié !');

        //on re-enregistre le livre en bdd
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('admin/book/update.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("admin/book/search", name="admin_book_search")
     */
    public function searchByResume(BookRepository $bookRepository)
    {

        // j'utilise le bookRepository pour appeler ma méthode "getByWordInResume()"
        // le bookRepository permet, en plus des méthodes find() etc par défaut,
        // de créer des méthodes plus spécifiques de SELECT de données en bdd
        $books = $bookRepository->getByWordInResume();

        dump($books); die;
    }

}
