<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Background;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        $types = ["Télévision", "Jeu Vidéo", "Consoles", "Téléphones"];
        $brands = ["Sony", "Microsoft", "Apple", "Nintendo"];

        
        for ($i=1; $i <= 30; $i++) { 
            $product = new Product();
            $name = "Produit Numero $i";
            $slug = $slugify->slugify($name);
            $description = $faker->paragraph(4);
            $type = $faker->randomElement($types);
            $brand = $faker->randomElement($brands);
            $image = 'https://fs-prod-cdn.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_4/2x1_NSwitch_SuperMarioBrosWonder_image1600w.jpg';

            $product->setName($name)
                ->setSlug($slug)
                ->setDescription($description)
                ->setPrice(rand(40,250))
                ->setType($type)
                ->setBrand($brand)
                ->setImage($image);

                //Gestion des images des produits
                for ($g=1; $g <= rand(3,5) ; $g++) { 
                    $background = new Background();
                    $background->setUrl('https://picsum.photos/id/'.$g.'/900')
                        ->setCaption($faker->sentence())
                        ->setRelation($product);
                    $manager->persist($background);
                }


            $manager->persist($product);
        }



        $manager->flush();
    }
}
