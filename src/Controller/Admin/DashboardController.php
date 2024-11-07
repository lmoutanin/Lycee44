<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Etudiant;
use App\Entity\Absence;
use App\Entity\Classe;
use App\Entity\Matiere;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {



        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // Option 1. You can make your dashboard redirect to some common page of your backend
        return $this->redirect($adminUrlGenerator->setController(AbsenceCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Accueil', 'fas fa-home', 'app_absence');
        yield MenuItem::linkToCrud('Etudiants', 'fas fa-solid fa-user', Etudiant::class);
        yield MenuItem::linkToCrud('Absences', 'fas  fa-head-side-mask', Absence::class);
        yield MenuItem::linkToCrud('Classes', 'fas fa-solid fa-user', Classe::class);
        yield MenuItem::linkToCrud('Matieres', 'fas fa-solid fa-user', Matiere::class);
    }
}
