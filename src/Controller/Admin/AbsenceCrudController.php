<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Entity\Absence;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AbsenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Absence::class;
    }



    // à ajouter
    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('date')->setRequired(true),
            TextField::new('matiere')->setRequired(true),
            BooleanField::new('justifie')->setFormTypeOption('label', 'Justifié'),
            AssociationField::new('etudiant')
                ->setRequired(true)
                ->setFormTypeOption('choice_label', fn($etudiant) => $etudiant->getPrenom() . ' ' . $etudiant->getNom() . ' (' . $etudiant->getClasse() . ')')
                ->setFormTypeOption('placeholder', 'Choisissez un étudiant')
        ];
    }
}
