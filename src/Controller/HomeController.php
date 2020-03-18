<?php

// je créé un namespace qui correspond au chemin vers cette classe
// (en gardant en tête que "App" = "src")
// et qui permet à Symfony d'"autoloader" ma classe
// sans que j'ai besoin de faire d'import ou de require à la main
namespace App\Controller;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use Symfony\Component\Routing\Annotation\Route;

// je créé ma classe HomeController et je la nomme de la même manière que mon fichier
class HomeController
{

    // je créé un commentaire en utilisant la classe Route (précédée d'un "@")
    // (ça s'appelle une annotation)
    // ce qui me permet de créer une url dans mon projet symfony
    // qui appelle le code de la méthode juste en dessous
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        var_dump('je suis bien sur la page home'); die;
    }

}
