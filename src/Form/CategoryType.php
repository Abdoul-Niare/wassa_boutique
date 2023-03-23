<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class, ['label' => "Libellé"])
        ->add('description',TextareaType::class, 
                ['attr' => ['class' => 'tinymce'],
                'label' => "Desciption", "required" => false])
        ->add('color',TextType::class, ['label' => "Couleur associée", "required" => false])
        ->add('picture1',FileType::class, [
            'label' => 'Photo 1 (png, jpg)',
            'mapped' => false,
            'required' => false,
            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/*'],
                    'mimeTypesMessage' => 'Merci de choisir un fichier au bon format (.jpg, .png)',               ])
            ],
        ])
        ->add('picture2',FileType::class, [
            'label' => 'Photo 2 (png, jpg)',
            'mapped' => false,
            'required' => false,
            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/*'],
                    'mimeTypesMessage' => 'Merci de choisir un fichier au bon format (.jpg, .png)',               ])
            ],
        ])
        ->add('submit', SubmitType::class, ['label' => "Enregistrer"])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
