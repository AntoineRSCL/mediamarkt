<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Image;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * Affiche tous les produits du site
     *
     * @param ProductRepository $repo
     * @return Response
     */
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $repo): Response
    {
        $products = $repo->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }


    #[Route("/products/new", name:"products_create")]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            //gestion des images
            foreach($product->getBackgrounds() as $background)
            {
                $background->setRelation($product);
                $manager->persist($background);
            }

            // je persiste mon objet Ad
            $manager->persist($product);
            // j'envoie les persistances dans la bdd
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>".$product->getName()."</strong> a bien été enregistrée");

            return $this->redirectToRoute('products_show',[
                'slug' => $product->getSlug()
            ]);

        }

        return $this->render("product/new.html.twig", [
            "myForm" => $form->createView()
        ]);
    }


    #[Route("/products/{slug}", name: "products_show")]
    public function show(string $slug, Product $product): Response
    {
        return $this->render("product/show.html.twig", [
            'product' => $product
        ]);
    }
}
