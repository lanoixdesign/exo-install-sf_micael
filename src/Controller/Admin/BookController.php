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
use App\Form\BookType;
use App\Repository\AuthorRepository;
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
    public function insertBook(Request $request, EntityManagerInterface $entityManager)

    {

        // 1 : En ligne de commandes, créer le BookType (le gabarit de formulaire)
        // 2 : dans le contrôleur, générer le formulaire avec $this->createView
        // 3 : afficher dans Twig le formulaire avec la fonction form

        // J'ai généré avec symfony un gabarit de formulaire (BookType)
        // qui contient déjà tous les inputs à créer en HTML
        // Je vais pouvoir utiliser ce gabarit de formulaire pour générer mon
        // formulaire HTML (donc tous mes champs inputs etc)

        // Je crée un nouveau livre, pour le lier à mon formulaire
        $book = new Book();

        // je crée mon formulaire et le je lie à mon nouveau livre
        $formBook = $this->createForm(BookType::class, $book);

        // je de mande à mon formulaire $formBook de gérer les données
        // de la requete POST
        $formBook->handleRequest($request);

        if ($formBook->isSubmitted() && $formBook->isValid()){

            // je persiste le book
            $entityManager->persist($book);
            $entityManager->flush();
        }

        //j'affiche le rendu de mon formulaire créé sur ma page twig
        return $this->render('admin/book/insert.html.twig', [
           'formBook' => $formBook->createView()
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
        Request $request,
        $id
    )
    {

        // récupérer un livre en bdd (avec le book repository et un id de livre)
        $book = $bookRepository->find($id);

        // je crée mon formulaire et le je lie à mon book selectionné
        $formBook = $this->createForm(BookType::class, $book);

        // je demande à mon formulaire $formBook de gérer les données
        // de la requete POST
        $formBook->handleRequest($request);

        if ($formBook->isSubmitted() && $formBook->isValid()){

            //on re-enregistre le livre en bdd
            $entityManager->persist($book);
            $entityManager->flush();
        }


        // on affiche le rendu dans le fichier twig
        return $this->render('admin/book/update.html.twig', [
            'formBook' => $formBook->createView()
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
