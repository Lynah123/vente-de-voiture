<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use App\Entity\Product;
use App\Form\StockType;
use App\Repository\StockRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/stock")
 */
class StockController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_stock_index", methods={"GET"})
     */
    public function index($id, StockRepository $stockRepository, ProductRepository $productRepo): Response
    {
        $product = $productRepo->findOneById($id);

        return $this->render('admin/stock/index.html.twig', [
            'stocks' => $stockRepository->findByProduct($id),
            'product' => $product
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_stock_new", methods={"GET", "POST"})
     */
    public function new($id, Request $request, StockRepository $stockRepository, Product $product, EntityManagerInterface $em): Response
    {
        $stock = new Stock();
        $form = $this->createForm(StockType::class, $stock, [
            'product' => $product
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \Datetime();

            $stock->setCreatedAt($date)
                  ->setProduct($product);

            $em->persist($stock);
            $em->flush();

            $quantity = $product->getQuantity() + $stock->getQuantity();

            $product->setQuantity($quantity);

            $em->persist($product);
            $em->flush();

            $message = "Votre stock a bien été enegistré, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_stock_index', [
                'id' => $product->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/stock/new.html.twig', [
            'stock' => $stock,
            'form' => $form,
            'product' => $product
        ]);
    }

    
}
