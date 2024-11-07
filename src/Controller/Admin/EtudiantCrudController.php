<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class EtudiantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
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

    public function configureFields(string $pageName ): iterable
    {
        return [
            TextField::new('nom')->setRequired(true),
            TextField::new('prenom')->setRequired(true),
            DateField::new('naissance')->setRequired(true),
            TextField::new('mail')->setRequired(true),
            AssociationField::new('classe')
                ->setRequired(false)
                ->setFormTypeOption('placeholder', 'Choisissez un classe')
        ];
    }
}
