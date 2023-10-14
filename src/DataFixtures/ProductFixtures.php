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

        
        for ($i=1; $i <= 30; $i++) { 
            $product = new Product();
            $name = "Produit Numero $i";
            $slug = $slugify->slugify($name);
            $description = $faker->paragraph(4);
            if ($i % 2 == 0) {
                $type = "Jeu Video";
                if($i > 15){
                    $brand = "Nintendo";
                }else{
                    $brand = "Playstation";
                }
            }else{
                $type = "Television";
                if($i > 15){
                    $brand = "Sony";
                }else{
                    $brand = "HP";
                }
            }
            $image = 'https://picsum.photos/seed/picsum/1000/350';

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
