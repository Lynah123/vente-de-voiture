<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use App\Repository\ProductDetailsRepository;
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

     /**
     * @Route("/{id}/product-details", name="app_product_details_front")
     */
    public function details($id, ProductDetailsRepository $productDetailsRepo, ProductRepository $productRepo): Response
    {
        $product = $productRepo->findOneById($id);
        $productsDetails = $productDetailsRepo->findByProduct($product);

        return $this->render('front/product/detail.html.twig', [
            'productsDetails' => $productsDetails
        ]);
    }
}
