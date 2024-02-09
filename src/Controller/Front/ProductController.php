<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(ProductRepository $productRepo): Response
    {
            $products = $productRepo->findAll();

        return $this->render('front/product/index.html.twig', [
            'products' => $products
        ]);
    }
}
