<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Entity\Etudiant;
use App\Entity\Absence;
use App\Form\SaisirAbsenceType;
use App\Form\RechercherAbsencesType;
use App\Repository\AbsenceRepository;
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
        // Créer une nouvelle absence
        $absence = new Absence();

        // Créer le formulaire d'absence en associant l'objet $absence
        $form = $this->createForm(SaisirAbsenceType::class);
        $form->handleRequest($request);

        if (($request->getMethod() == 'POST') && ($form->isValid())) {

            // Récupérer les données du formulaire (l'objet Absence)
            $absence = $form->getData();

            // Persister et sauvegarder dans la base de données
            $entityManager->persist($absence);
            $entityManager->flush();

            // Rediriger vers la liste des absences
            return $this->redirectToRoute('liste_absences');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, on l'affiche
        return $this->render('absence/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/absence/liste', name: 'liste_absences')]
    public function liste(AbsenceRepository $absenceRepository): Response
    {
        // Récupèration de tous les étudiants
        $absence = $absenceRepository->findAll();  // SELECT * FROM etudiant


        return $this->render('absence/liste_absences.html.twig', [
            'absences' => $absence

        ]);
    }



    #[Route('/absence/rechercher', name: 'rechercher_absences')]
    public function rechercherAbsences(
        Request $request,
        EtudiantRepository $etudiantRepository,
        AbsenceRepository $absenceRepository
    ): Response {
        // Création du formulaire
        $form = $this->createForm(RechercherAbsencesType::class);
        $form->handleRequest($request);

        $absences = [];
        $etudiant = null;
        $formSubmitted = false;

        // Vérification de la soumission et de la validité du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $formSubmitted = true; // Le formulaire a été soumis
            $data = $form->getData();
            $etudiant = $etudiantRepository->findOneBy(['nom' => $data['nom']]);

            if ($etudiant) {
                $absences = $absenceRepository->findBy(['etudiant' => $etudiant]);
            }
        }

        return $this->render('absence/rechercher_absences.html.twig', [
            'form' => $form->createView(),
            'absences' => $absences,
            'etudiant' => $etudiant,
            'formSubmitted' => $formSubmitted,
        ]);
    }
}
