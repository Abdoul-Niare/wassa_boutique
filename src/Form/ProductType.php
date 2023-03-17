<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('code')
            ->add('added_date')
            ->add('updated_date')
            ->add('picture1')
            ->add('picture2')
            ->add('picture3')
            ->add('picture4')
            ->add('description')
            ->add('dozen_price')
            ->add('nb_dozen')
            ->add('nb_total')
            ->add('public_price')
            ->add('promos_price')
            ->add('discount_rate')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
