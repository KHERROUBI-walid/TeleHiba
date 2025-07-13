<?php

// src/Form/CategorieForm.php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategorieForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nom_categorie', TextType::class, [
            'label' => 'categorie.add.name',
            'attr' => [
                'placeholder' => 'categorie.add.name_placeholder',
                'class' => 'mt-1 w-full px-4 py-3 rounded-xl bg-[#F4F5FF] text-sm focus:ring-2 focus:ring-[#8C85FF] focus:outline-none',
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}

