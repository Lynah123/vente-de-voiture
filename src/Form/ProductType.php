<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Brand;
use App\Form\TypeType;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ProductTypeSubscriber;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3',
                    'autocomplete' => 'off'
                ],
                'label' => 'Titre',
            ])

            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'title',
                'attr' => [
                    'class' => 'form-control form-control-md brand-select mb-3'
                ],
                'label' => 'Marque'
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'title',
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control form-control-md brand-select mb-3'
                ],
            ])
            ->add('type', EntityType::class, [
                'class' => 'App\Entity\Type',
                'choice_label' => 'title',
                'label' => 'Type',
                'attr' => [
                    'class' => 'form-control form-control-md brand-select mb-3'
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3',
                ],
                'label' => 'Quantité(s)'
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3',
                    'autocomplete' => 'off'
                ],
                'label' => 'Prix'
            ])
            ->add('imageFile', VichImageType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3',
                ],
                'allow_delete' => true,
                'delete_label' => 'Supprimer',
                'download_label' => 'Télécharger',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control form-control-md mb-3',
                    'rows' => 5
                ],
            ])
        ;
    }
   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
