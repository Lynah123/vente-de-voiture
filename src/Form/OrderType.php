<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Carrier;
use App\Repository\CarrierRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $client = $options['client'];

        $builder
            ->add('adresses', EntityType::class, [
                'class' => Adresse::class,
                'label' => 'Choisissez votre adrese de livraison',
                'required' => true,
                'choices' => $client->getAdressesDelivery(),
                'multiple' => false,
                'expanded' => true
            ])
            ->add('carriers', EntityType::class, [
                'class' => Carrier::class,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'client' => array()
        ]);
    }
}
