<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProductRepository $productRepo): Response
    {
        $product = $productRepo->findBy(['isActive' => true, 'isOutOfStock' => false]);
        return $this->render('front/home/index.html.twig', [
            'products' => $product,
        ]);
    }
}
