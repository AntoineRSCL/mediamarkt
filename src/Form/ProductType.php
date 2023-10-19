<?php

namespace App\Form;

use App\Entity\Product;
use App\Form\BackgroundType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration('Nom', "Donnez le nom du produit"))
            ->add('description', TextareaType::class, $this->getConfiguration('Description', "Donnez une description de votre produit"))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix','Indiquer le prix que vous voulez pour le produit'))
            ->add('type', TextType::class, $this->getConfiguration('Type', "Entrez le type du produit"))
            ->add('brand', TextType::class, $this->getConfiguration('Marque', "Donnez la marque du produit"))
            ->add('image', UrlType::class, $this->getConfiguration("Url de l'image", "Donnez l'adresse de votre image"))
            ->add('slug', TextType::class, $this->getConfiguration('Slug', 'Adresse web (automatique)',[
                'required' => false
            ]))
            ->add('backgrounds', CollectionType::class,[
                'entry_type'=>BackgroundType::class,
                'allow_add'=> true, //pour le data prototype
                'allow_delete'=>true
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
