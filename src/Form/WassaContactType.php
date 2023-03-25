<?php

namespace App\Form;

use App\Entity\WassaContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class WassaContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, ['label' => 'Votre nom',])
            ->add('email',EmailType::class, ['label' => 'Votre email'])
            ->add('phone',TextType::class, ['label' => 'Votre numéro de Tel','required' => false])
            ->add('subject',ChoiceType::class, ['choices'  => [
                                                'Autre' => "Autre",
                                                "Demande d'informations" => "Demande Informations",
                                                ],'label' => 'Objet du message'])    
            ->add('message',TextareaType::class,['label' => 'Votre message'])
            // ->add('captcha', CaptchaType::class, array(
            //         'invalid_message' => 'Le code saisi est incorrect',
            //         'width' => 200,
            //         'height' => 50,
            //         'length' => 6,))
            ->add('send', SubmitType::class, ['label' => 'Envoyer'])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WassaContact::class,
        ]);
    }
}
