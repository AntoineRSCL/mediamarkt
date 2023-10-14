<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
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


    #[Route("/products/{slug}", name: "products_show")]
    public function show(string $slug, Product $product): Response
    {
        return $this->render("product/show.html.twig", [
            'product' => $product
        ]);
    }
}
