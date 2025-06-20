<?php

namespace App\Controller\Admin;

use App\Entity\Absence;
use App\Entity\Matiere;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AbsenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Absence::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('date')->setRequired(true),
            TextField::new('justifie'),
            AssociationField::new('etudiant')
                ->setRequired(true)
                ->setFormTypeOption('placeholder', 'Choisissez un étudiant'),
            AssociationField::new('matiere')
                ->setRequired(true)
                ->setFormTypeOption('placeholder', 'Choisissez une matiere')



        ];
    }
}
