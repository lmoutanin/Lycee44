<?php

namespace App\Controller;

use App\Entity\Etudiant;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SaisirEtudiantType;
use Symfony\Component\HttpFoundation\Request;


class EtudiantController extends AbstractController
{

    #[Route('/etudiant/creer/', name: 'etudiant_creer')]
    public function createEtudiant(ManagerRegistry $doctrine): Response
    {
        // Récupère l'EntityManager de Doctrine, nécessaire pour interagir avec la base de données
        $entityManager = $doctrine->getManager();

        // Création de l'étudiant
        $etudiant = new Etudiant();
        $etudiant->setNom('JOHN');
        $etudiant->setPrenom('CAZA');
        $etudiant->setNaissance(new DateTime("2003-01-13"));
        $etudiant->setNiveau(1);
        $etudiant->setMail('JOHNCaza@gmail.com');

        // Prépare Doctrine à sauvegarder l'étudiant (mais n'exécute pas encore la requête SQL)
        $entityManager->persist($etudiant);

        // Exécute la requête SQL pour insérer les données dans la base de données
        $entityManager->flush();

        return new Response('Nouvel étudiant sauvegardé, ID ' . $etudiant->getId());
    }



    #[Route('/etudiant/afficher/{id}', name: 'etudiant_afficher')]
    public function afficherAvecRepository(int $id, EtudiantRepository $etudiantRepository): Response
    {
        $etudiant = $etudiantRepository->find($id);

        // Si aucun étudiant n'est trouvé, une exception est levée pour indiquer que l'étudiant n'existe pas
        if (!$etudiant) {
            throw $this->createNotFoundException('Aucun étudiant trouvé pour cet ID.');
        }
        return new Response('Le nom de l\'étudiant est : ' . $etudiant->getNom());
    }


    #[Route('/changement', name: 'changement_niveau')]
    public function changementNiveau(
        EntityManagerInterface $entityManager,
        EtudiantRepository $etudiantRepository
    ): Response {
        // Récupèration de tous les étudiants
        $etudiants = $etudiantRepository->findAll(); // SELECT * FROM etudiant

        // Modification du niveau de chaque étudiant
        foreach ($etudiants as $etudiant) {
            $etudiant->setNiveau(2); // Mise à jour du champ niveau
        }

        // Enregistre les modifications en base
        $entityManager->flush();

        // Renvoie une réponse
        return new Response('Modification du niveau pour ' . count($etudiants) . ' étudiant(s).');
    }


    #[Route('/etudiant/rechercher/nom/{nom}', name: 'etudiant_rechercher_nom')]
    public function rechercherNom(
        String $nom,
        EtudiantRepository $etudiantRepository
    ) {

        $etudiants = $etudiantRepository->findStudentByName($nom);
        // $etudiants = $etudiantRepository->findStudentByNameSQL($nom);

        return $this->render('etudiant/rechercher_nom.html.twig', [
            'nom' => $nom,
            'etudiants' => $etudiants
        ]);
    }

    #[Route('/etudiant/modifier/{id}', name: 'etudiant_modifier')]
    public function modifierEtudiant(
        int $id,
        EntityManagerInterface $entityManager,
        EtudiantRepository $etudiantRepository
    ) {

        // récupération du post avec id passé en paramètre
        $etudiant = $etudiantRepository->find($id);
        // equivalent à SELECT * FROM etudiant WHERE id=X

        if (!$etudiant) {
            return new Response('Étudiant avec ID ' . $id . ' non trouvé.', Response::HTTP_NOT_FOUND);
        }

        // modification des éléments de l'étudiant
        $etudiant->setNom('ALI');
        $etudiant->setPrenom('Muhammad');
        $etudiant->setMail('AliMuhammad@gmail.com');

        // enregistrement des modifications dans la base de données
        $entityManager->flush();
        return new Response('Modification OK sur : ' . $etudiant->getId());
    }

    #[Route('/etudiant/create', name: 'etudiant_new')]
    public function saisirEtudiant(
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        // Création du formulaire
        $form = $this->createForm(SaisirEtudiantType::class);
        $form->handleRequest($request);

        $id = $request->get('id');


        // Si id de étudiant n'existe pas créé un nouvelle étudiant 


        if (($request->getMethod() == 'POST') && ($form->isValid())) {
            $etudiant = $form->getData();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $etudiant = new Etudiant();
            $form = $this->createForm(SaisirEtudiantType::class, $etudiant);
        }

        // Si le formulaire n'a pas été soumis ou est invalide, affiche le formulaire
        return $this->render('etudiant/createEtudiant.html.twig', [
            'form' => $form->createView()
        ]);
    }



    //Il faut place ce block de code en dernier .Parce que ce dernier va crée des probléme de route il faudra ajouter id à la fin 
    #[Route('/etudiant/{id}', name: 'etudiant_id')]
    public function afficher(ManagerRegistry $doctrine, int $id): Response

    {
        $etudiant = $doctrine->getRepository(Etudiant::class)->find($id);

        if (!$etudiant) {
            throw $this->createNotFoundException(
                'Pas d\'étudiant trouvé avec cet ' . $id
            );
        }

        return new Response('Le nom de l\'étudiant est : ' . $etudiant->getNom());
    }
}
