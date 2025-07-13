<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;

class ProduitForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom_categorie',
                'placeholder' => 'product.add.choose_category',
                'label' => 'product.add.category',
                'attr' => [
                    'class' => 'mt-1 w-full px-4 py-3 rounded-xl bg-[#F4F5FF] text-sm focus:ring-2 focus:ring-[#8C85FF] focus:outline-none'
                ]
            ])
            ->add('nom_produit', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => ['maxlength' => 70],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['maxlength' => 200],
            ])
            ->add('prix', MoneyType::class, [
                'currency' => false,
            ])
            ->add('quantite_dispo', NumberType::class, [
                'label' => 'Quantité disponible',
            ])
            ->add('image_url', FileType::class, [
                'label' => 'Image du produit',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.webp',
                ],
                'constraints' => [
                    new File(
                        maxSize: '6M',
                        mimeTypes: [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        mimeTypesMessage: 'Veuillez télécharger une image au format JPG, PNG ou WEBP.',
                    ),
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'is_edit' => false,
        ]);
    }
}
