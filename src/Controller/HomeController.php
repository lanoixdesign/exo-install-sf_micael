<?php

// je créé un namespace qui correspond au chemin vers cette classe
// (en gardant en tête que "App" = "src")
// et qui permet à Symfony d'"autoloader" ma classe
// sans que j'ai besoin de faire d'import ou de require à la main
namespace App\Controller;

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
class HomeController extends AbstractController
{

    /**
     * @Route("/books", name="book_list")
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

        return $this->render('books.html.twig', [
           'books' => $books
        ]);

    }

    /**
     * @Route("/book/show/{id}", name="book_show")
     */
    public function book($id, BookRepository $bookRepository)
    {
        $book = $bookRepository->find($id);

        return $this->render('book.html.twig', [
            'book' => $book
        ]);
    }


    /**
     * @Route("/book/insert", name="book_insert")
     */
    public function insertBook(EntityManagerInterface $entityManager)
    {

        // Pour créer un enregistrement de Book en bdd, j'utilise une instance de l'entité Book
        // Doctrine va faire le lien et transformer mon entité en nouvel enregistrement
        $book = new Book();

        // j'utilise les setters de mon entité pour donner les valeurs à chaque propriétés (donc à chaque
        // colonne en BDD)
        $book->setTitle('titre depuis le controleur');
        $book->setAuthor('JPP');
        $book->setNbPages(200);
        $book->setResume('terif eoirfrnv ieuuirnà');

        // j'utilise l'EntityManager avec la méthode persist pour sauvegarder mon entité (similaire à un commit
        // Attention ça n'enregistre pas encore en BDD
        $entityManager->persist($book);

        // j'utilise la méthode flush pour enregistrer en bdd (execute la requête SQL)
        $entityManager->flush();

        return new Response('livre enregistré');

    }

}
