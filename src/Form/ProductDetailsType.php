<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Brand;
use App\Entity\Category;
use App\Form\ColorFormType;
use App\Entity\ProductDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control form-control mb-3'
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ]
            ])
            ->add('price', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ]
            ])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'title',
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ]
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'title',
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDetails::class,
        ]);
    }
}
