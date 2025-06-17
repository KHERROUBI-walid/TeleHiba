<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Connexion
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(message: 'Merci d’entrer un mot de passe.'),
                    new Length(
                        min: 6,
                        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        max: 4096,
                    ),
                ],
            ])

            // Type utilisateur
            ->add('typeUtilisateur', ChoiceType::class, [
                'label' => 'Type de compte',
                'choices' => [
                    'Famille' => 'famille',
                    'Donateur' => 'donateur',
                    'Vendeur' => 'vendeur',
                ],
                'placeholder' => ' ',
            ])

            // Informations personnelles
            ->add('civilite', ChoiceType::class, [
                'choices' => [
                    'Mme' => 'Mme',
                    'M.' => 'M.',
                    'Autre' => 'Autre',
                ],
                'placeholder' => ' ',
            ])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)

            // Coordonnées
            ->add('telephone', TelType::class, ['required' => false])
            ->add('adresse', TextType::class, ['required' => false])
            ->add('complAdresse', TextType::class, ['required' => false])
            ->add('codePostal', TextType::class, ['required' => false])
            ->add('ville', TextType::class, ['required' => false])
            ->add('pays', TextType::class, ['required' => false])

            // Conditions d’utilisation
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "J'accepte les conditions d'utilisation",
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions d’utilisation.'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
