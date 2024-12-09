<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Classe;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert; // validator
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SaisirEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(['message' => "Le nom ne peut pas être vide."]),
                new Assert\Length([
                    'min' => 3,
                    'minMessage' => "Le nom doit contenir au moins {{ limit }} caractères. (formulaire)",
                ]),
            ],
        ])
            ->add('prenom', TextType::class)
            ->add('naissance', null, [
                'widget' => 'single_text',
            ], DateType::class)
            ->add('classe', ChoiceType::class, [
                'placeholder' => false,
            ])
            ->add('mail', TextType::class)
            ->add('envoyer', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
