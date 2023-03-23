<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => "Libellé", "required" => true])
            ->add('price', TextType::class,  ['label' => "Prix unité", 'required' => false])
            ->add('code', TextType::class, ['label' => "Code", "required" => false])
            ->add('category', EntityType::class, ['class' => \App\Entity\Category::class, "required" => true, 'label' => "Catégorie"])
            ->add('dozenPrice', TextType::class,  ['label' => "Prix Douzaine", 'required' => false])
            ->add('publicPrice', TextType::class,  ['label' => "Prix affiché", 'required' => false])
            ->add('promosPrice', TextType::class,  ['label' => "Prix promos", 'required' => false])
            ->add('nbDozen', TextType::class,  ['label' => "Nb douzaine", 'required' => false])
            ->add('nbTotal', TextType::class,  ['label' => "Nb Total", 'required' => false])
            ->add('discountRate', TextType::class,  ['label' => "Pourcentage reduction", 'required' => false])
            // ->add('onDiscount', CheckboxType::class, ['label'    => 'En promos ?', 'required' => false,])
            // ->add('updated_date')
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description', "required" => false,
                    'attr' => ['class' => 'text-editor']
                ]
            )
            ->add('document1', FileType::class, [
                'label' => "Image 1",
                'mapped' => false, "required" => false
            ])
            ->add('document2', FileType::class, [
                'label' => "Image 2",
                'mapped' => false, "required" => false
            ])
            ->add('document3', FileType::class, [
                'label' => "Image 3",
                'mapped' => false, "required" => false
            ])
            ->add('document4', FileType::class, [
                'label' => "Image 4",
                'mapped' => false, "required" => false
            ])
            ->add('submit', SubmitType::class, ['label' => "Enregistrer"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
