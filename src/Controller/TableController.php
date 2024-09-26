<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TableChoiceType;


class TableController extends AbstractController
{
    #[Route('/table', name: 'app_table')]
    public function index(): Response
    {
        return $this->render('table/index.html.twig', [
            'controller_name' => 'TableController',
        ]);
    }


    #[Route('/table/print', name: 'table_print')]
    public function print(): Response
    {
        $nombre = 2;
        $resultats = [];
        for ($i = 0; $i <= 10; $i++) {
            $resultats[$i] =  $nombre * $i;
        }
        return $this->render('table/print.html.twig', [
            'nombre' => $nombre,
            'resultats' => $resultats

        ]);
    }

    #[Route('/table/printn', name: 'table_printn')]
    public function printn(Request $requete): Response
    {
        $nombre = $requete->get('n');
        $resultats = [];
        for ($i = 0; $i <= 10; $i++) {
            $resultats[$i] =  $nombre * $i;
        }
        return $this->render('table/print.html.twig', [
            'nombre' => $nombre,
            'resultats' => $resultats

        ]);
    }

    #[Route('/table/select')]
    public function select(Request $req)
    {
        // Création du formulaire
        $form = $this->createForm(TableChoiceType::class);
        $form->handleRequest($req);

        // Vérifie si le formulaire a été soumis et est valide
        //  if ($form->isSubmitted() && $form->isValid()) {
        if (($req->getMethod()== 'POST') && ($form->isValid())) {
            // Récupère les données soumises
            $dataFormulaire = $form->getData();

            // Récupère la valeur d'un champ spécifique du formulaire
            $retour['n'] = $dataFormulaire['number'];

            // Redirige vers une autre route avec les données passées
            return $this->redirectToRoute('table_printn', $retour);
        }

        // Si le formulaire n'a pas été soumis ou est invalide, affiche le formulaire
        return $this->render('table/select.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
