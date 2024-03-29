<?php

namespace App\Form;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-4',
                    'autocomplete' => 'off'
                ],
                'label' => 'Nom de Fournisseur'
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-4',
                    'autocomplete' => 'off'
                ],
                'label' => 'Adresse'
                ])
            ->add('phoneNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-4',
                    'autocomplete' => 'off'
                ],
                'label' => 'Numéro Téléphone'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}
