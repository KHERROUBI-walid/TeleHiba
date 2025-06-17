<?php

namespace App\Form;

use App\Entity\Famille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreMembres', IntegerType::class, [
                'label' => 'Nombre de membres dans la famille',
                'required' => true,
            ])
            ->add('revenuMensuel', MoneyType::class, [
                'label' => 'Revenu mensuel (en €)',
                'required' => true,
                'currency' => 'EUR', // tu peux changer si c'est en MAD par ex.
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Famille::class,
        ]);
    }
}
