<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Absence;
use App\Form\SaisirAbsenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AbsenceController extends AbstractController
{
    #[Route('/absence', name: 'app_absence')]
    public function index(): Response
    {
        return $this->render('absence/index.html.twig', [
            'controller_name' => 'AbsenceController',
        ]);
    }

    #[Route('/absence/ajouter', name: 'absence_ajouter')]
    public function ajouterAbsence(Request $request, EntityManagerInterface $entityManager): Response
    {
 
        $form = $this->createForm(SaisirAbsenceType::class);
        $form->handleRequest($request);
 

        if (($request->getMethod() == 'POST') && ($form->isValid())) {
            $absence = $form->getData();
            $entityManager->persist($absence);
            $entityManager->flush();
            $absence = new Absence();
            $form = $this->createForm(SaisirAbsenceType::class, $absence);
        }
 
      // Si le formulaire n'a pas été soumis ou n'est pas valide, on l'affiche
        return $this->render('absence/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
