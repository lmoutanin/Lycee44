<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AbsenceController extends AbstractController
{
    #[Route('/absence', name: 'app_absence')]
    public function index(): Response
    {
        return $this->render('absence/index.html.twig', [
            'controller_name' => 'AbsenceController',
        ]);
    }
}
