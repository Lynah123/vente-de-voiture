<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-4',
                    'autocomplete' => 'off'
                ],
                'label' => 'Marque'
            ])
            ->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control form-control-md mb-3'
                ],
                'label' => 'Fournisseur'
            ])

            ->add('types', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Type::class,
                    'choice_label' => function(Type $type) {
                        return $type->getTitle();
                    }
                    
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'class' => 'mb-3'
                ]
                
            ])

            ->add('categories', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Category::class,
                    'choice_label' => function(Category $cat) {
                        return $cat->getTitle();
                    }
                    
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'class' => 'mb-3'
                ]
                
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brand::class,
        ]);
    }
}
