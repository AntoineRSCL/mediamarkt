<?php

namespace App\Form;

use App\Entity\Background;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BackgroundType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url',UrlType::class,[
                'attr'=>[
                    'placeholder'=> 'Url de l\'image'
                ]
            ])
            ->add('caption',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Titre de l\'image'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Background::class,
        ]);
    }
}
