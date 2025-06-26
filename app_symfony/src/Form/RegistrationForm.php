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
    private function getInputClasses(): string
    {
        return 'mt-1 w-full px-4 py-3 rounded-xl bg-[#F4F5FF] text-sm focus:ring-2 focus:ring-[#8C85FF] focus:outline-none';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = $this->getInputClasses();

        $builder
            // Connexion
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'form.password',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => $inputClass,
                ],
                'constraints' => [
                    new NotBlank(message: 'Merci d’entrer un mot de passe.'),
                    new Length(
                        min: 6,
                        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        max: 4096,
                    ),
                ],
            ])

            ->add('typeUtilisateur', ChoiceType::class, [
                'label' => 'register.account_type.label',
                'placeholder' => 'register.account_type.placeholder',
                'choices' => [
                    'register.account_type.famille' => 'famille',
                    'register.account_type.donateur' => 'donateur',
                    'register.account_type.vendeur' => 'vendeur',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
                'attr' => [
                    'class' => $inputClass,
                ],
            ])

            ->add('civilite', ChoiceType::class, [
                'label' => 'register.civility.label',
                'placeholder' => 'register.civility.placeholder',
                'choices' => [
                    'register.civility.mme' => 'Mme',
                    'register.civility.mr' => 'M.',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
                'attr' => [
                    'class' => $inputClass,
                ],
            ])


            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => $inputClass,
                ],
            ])

            // Coordonnées
            ->add('telephone', TelType::class, [
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('complAdresse', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('codePostal', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => $inputClass,
                ],
            ])
            ->add('pays', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => $inputClass,
                ],
            ])

            // Conditions d’utilisation
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'form.terms_agree',
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions d’utilisation.'),
                ],
                'attr' => [
                    'class' => 'form-checkbox rounded text-[#673DE6]',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
