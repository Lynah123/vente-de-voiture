<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use App\Repository\ProductDetailsRepository;
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
            [], // Aucun critère de recherche spécifié ici
            ['createdAt' => 'DESC'], // Ordre par createdAt descendant
            6 // Nombre maximal de résultats
        );

        return $this->render('front/home/index.html.twig', [
            'products' => $products,
        ]);
    }

}
