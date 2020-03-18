<?php

// je créé un namespace qui correspond au chemin vers cette classe
// (en gardant en tête que "App" = "src")
// et qui permet à Symfony d'"autoloader" ma classe
// sans que j'ai besoin de faire d'import ou de require à la main
namespace App\Controller;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// je créé ma classe HomeController et je la nomme de la même manière que mon fichier
class HomeController
{

    // je créé un commentaire en utilisant la classe Route (précédée d'un "@")
    // (ça s'appelle une annotation)
    // ce qui me permet de créer une url dans mon projet symfony
    // qui appelle le code de la méthode juste en dessous

    // on créé un parametre d'url age avec symfony, alias une "wildcard"
    // qu'on récupère ensuite en passant en parametre de la méthode une variable
    // qui a le même nom que la "wildcard"

    /**
     * @Route("/{age}", name="home")
     */
    public function home(Request $request, $age)
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
            $message = '<h1>Cass\' toi pauv\' con !</h1>';
        }

        // j'utilise la classe Response du composant HTTP Foundation pour créer une réponse
        $response = new Response($message);

        // je retourne la réponse créée
        return $response;

    }

}
