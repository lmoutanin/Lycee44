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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;


class EtudiantController extends AbstractController
{

    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator; // On assigne le validateur à la propriété de classe
    }
    
    private function validerEtudiant(Etudiant $etudiant): ConstraintViolationListInterface
    {
        // Utilise le validateur Symfony pour valider les contraintes définies dans l'entité Étudiant
        return $this->validator->validate($etudiant);
    }

    #[Route('/etudiant/creer/', name: 'etudiant_creer')]
    public function createEtudiant(ManagerRegistry $doctrine): Response
    {
        // Récupère l'EntityManager de Doctrine, nécessaire pour interagir avec la base de données
        $entityManager = $doctrine->getManager();

        // Création de l'étudiant
        $etudiant = new Etudiant();
        $etudiant->setNom('JOHNny');
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
    public function saisirEtudiant(Request $request, EntityManagerInterface $entityManager): Response
{
    // Création d'un nouvel étudiant vide
    $etudiant = new Etudiant();

    // Création du formulaire
    $form = $this->createForm(SaisirEtudiantType::class, $etudiant);

    // Gestion de la requête
    $form->handleRequest($request);

    // Si le formulaire est soumis
    if ($form->isSubmitted()) {
        // Appelle la méthode de validation
        $violations = $this->validerEtudiant($etudiant);

        // Si des violations sont détectées
        if (count($violations) > 0) {
            // Rassemble les messages d'erreur dans une chaîne
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
            }

            // Retourne une réponse contenant les erreurs
            return $this->render('etudiant/createEtudiant.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors,
            ]);
        }

        // Si tout est valide, sauvegarde l'étudiant dans la base de données
        if ($form->isValid()) {
            $entityManager->persist($etudiant);
            $entityManager->flush();

            // Redirection ou message de confirmation
            return new Response('Etudiant sauvegardé avec succès, son ID est : ' . $etudiant->getId());
            // return $this->redirectToRoute('etudiant_afficher', ['id' => $etudiant->getId()]);
        }
    }

    // Affichage du formulaire (si non soumis ou non valide)
    return $this->render('etudiant/createEtudiant.html.twig', [
        'form' => $form->createView(),
        'errors' => [], // Pas d'erreurs à afficher au premier affichage
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
