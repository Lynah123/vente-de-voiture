<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Entity\Brand;
use App\Entity\Stock;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Form\UpdateProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $product = new Product();

        $stock = new Stock();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$productRepository->add($product, true);
            $date = new \Datetime();

            $em->persist($product);
            $em->flush();

            $stock->setProduct($product)
                  ->setQuantity($product->getQuantity())
                  ->setCreatedAt($date);
                  
            $em->persist($stock);
            $em->flush();

            $message = "Votre produit a bien été enegistré, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(UpdateProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            $message = "Votre produit a bien été modifié, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        $message = "Votre produit a bien été supprimé, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
