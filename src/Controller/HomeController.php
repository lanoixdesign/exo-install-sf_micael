<?php

// je créé un namespace qui correspond au chemin vers cette classe
// (en gardant en tête que "App" = "src")
// et qui permet à Symfony d'"autoloader" ma classe
// sans que j'ai besoin de faire d'import ou de require à la main
namespace App\Controller;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// je créé ma classe HomeController et je la nomme de la même manière que mon fichier
class HomeController extends AbstractController
{

    // je créé un commentaire en utilisant la classe Route (précédée d'un "@")
    // (ça s'appelle une annotation)
    // ce qui me permet de créer une url dans mon projet symfony
    // qui appelle le code de la méthode juste en dessous

    // on créé un parametre d'url age avec symfony, alias une "wildcard"
    // qu'on récupère ensuite en passant en parametre de la méthode une variable
    // qui a le même nom que la "wildcard"

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/poker/{age}", name="poker")
     */
    public function poker(Request $request, $age)
    {
        // je stocke dans une variable tous les parametres de Request
        // à savoir les données de la requête de l'utilisateur
        // $request = Request::createFromGlobals();

        // dans les données de requête, je récupère uniquement le parametre d'url "age"
        //$age = $request->query->get('age');

        // si l'âge est supérieur ou égal à 18, j'affiche un message d'accueil
        if ($age >= 18 ) {
            $message = '<h1>Vous pouvez accéder à ce site !</h1>';
        // sinon j'affiche un autre message
        } else {
            // je veux renvoyer vers la page error home

            // fait une redirection vers une url "en dur"
            //return $this->redirect('http://exo-install-sf:8888/home/error');

            // fait une redirection vers la route "error_home", symfony va automatiquement "calculer"
            // l'url de la page
            return $this->redirectToRoute("poker_error");

        }

        // j'utilise la classe Response du composant HTTP Foundation pour créer une réponse
        $response = new Response($message);

        // je retourne la réponse créée
        return $response;

    }

    /**
     * @Route("/error", name="poker_error")
     */
    public function errorHome()
    {
        $message = "<h1>vous ne pouvez pas accéder à ce site !</h1>";

        $response = new Response($message);

        return $response;
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function twig()
    {

        $name = 'Robert'; // simulation d'une requête en base de données
        $firstName = 'David';

        $sports = [
            'surf',
            'escalade'
        ];

        // j'utilise la méthode render (issue de la classe AbsractController)
        // pour renvoyer un fichier html/twig en Réponse
        return $this->render('profil.html.twig', [
            'name' => $name,
            'firstName' => $firstName,
            'sports' => $sports
        ]);
    }


    /**
     * @Route("/articles/{id}", name="articles")
     */
    public function blog($id)
    {
        $articles = [
            1 => [
                'title' => 'titre article 1',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMiF_QYKvu_SgiciSMJ7AwfSOl7I_VLJAC_23h9X102-sKZP_3',
                'published' => true
            ],
            2 => [
                'title' => 'titre article 2',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMiF_QYKvu_SgiciSMJ7AwfSOl7I_VLJAC_23h9X102-sKZP_3',
                'published' => true
            ],
            3 => [
                'title' => 'titre article 3',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMiF_QYKvu_SgiciSMJ7AwfSOl7I_VLJAC_23h9X102-sKZP_3',
                'published' => false
            ],
            4 => [
                'title' => 'titre article 4',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMiF_QYKvu_SgiciSMJ7AwfSOl7I_VLJAC_23h9X102-sKZP_3',
                'published' => false
            ],
            5 => [
                'title' => 'titre article 5',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMiF_QYKvu_SgiciSMJ7AwfSOl7I_VLJAC_23h9X102-sKZP_3',
                'published' => true
            ],
            6 => [
                'title' => 'titre article 6',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQMiF_QYKvu_SgiciSMJ7AwfSOl7I_VLJAC_23h9X102-sKZP_3',
                'published' => true
            ]
        ];

        $article = $articles[$id];

        return $this->render('articles.html.twig', [
           'article' => $article
        ]);

    }

}
