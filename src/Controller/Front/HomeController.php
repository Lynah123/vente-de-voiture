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
        $products = $productRepo->findBy(
            ['isActive' => true, 'isOutOfStock' => false], // Critères de recherche
            ['createdAt' => 'DESC'], // Tri par date de création décroissante
            6 // Limite de résultats à 6 produits
        );
        return $this->render('front/home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
