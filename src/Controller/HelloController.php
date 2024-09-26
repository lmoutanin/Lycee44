<?php

// src/Controller/HelloController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    #[Route('/hello/world')]
    public function world(): Response
    {
        return $this->render(
            'hello_world.html.twig'
        );
    }
}
