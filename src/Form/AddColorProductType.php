<?php

namespace App\Form;

use App\Entity\Color;
use App\Form\ColorFormType;
use App\Entity\ProductDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddColorProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('colors', CollectionType::class, [
            // each entry in the array will be an "email" field
            'entry_type' => ColorFormType::class,
            'label' => 'Couleurs',
            'allow_add' => true,
            'allow_delete' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
