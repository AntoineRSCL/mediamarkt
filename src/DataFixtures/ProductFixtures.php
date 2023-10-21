<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Background;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
;

class ProductFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        $types = ["Télévision", "Jeu Vidéo", "Consoles", "Téléphones"];
        $brands = ["Sony", "Microsoft", "Apple", "Nintendo"];

        $users = []; //Init d'un tableau pour recup des users pour les annonces
        $genres = ['male', "femelle"];

        //Création des membres
        for ($u=1; $u <= 10; $u++) { 
            $user = new User();
            $genre = $faker->randomElement($genres);

            $hash = $this->passwordHasher->hashPassword($user, 'StandardChampion');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.join("<p></p>",$faker->paragraphs(3)).'</p>')
                ->setPassword($hash)
                ->setPicture('');

            $manager->persist($user);

            $users[] = $user; // ajouter un user au tableau(pour les annonces)
        }

        
        for ($i=1; $i <= 30; $i++) { 
            $product = new Product();
            $name = "Produit Numero $i";
            $description = $faker->paragraph(4);
            $type = $faker->randomElement($types);
            $brand = $faker->randomElement($brands);
            $image = 'https://fs-prod-cdn.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_4/2x1_NSwitch_SuperMarioBrosWonder_image1600w.jpg';

            //liaison avec l'user
            $user = $users[rand(0, count($users)-1)];

            $product->setName($name)
                ->setDescription($description)
                ->setPrice(rand(40,250))
                ->setType($type)
                ->setBrand($brand)
                ->setImage($image)
                ->setSeller($user);

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
