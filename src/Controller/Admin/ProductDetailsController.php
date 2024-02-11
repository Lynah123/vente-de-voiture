<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use App\Entity\ProductDetails;
use App\Form\ProductDetailType;
use App\Form\ProductDetailsType;
use App\Form\AddColorProductType;
use App\Repository\ColorRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductDetailsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductDetailsController extends AbstractController
{

     /**
     * @Route("/admin/{id}/detail", name="app_detail_product_show", methods={"GET"})
     */
    public function show(ProductDetails $productDetail): Response
    {
        return $this->render('admin/product_details/show.html.twig', [
            'productDetail' => $productDetail,
        ]);
    }
    
   /**
 * @Route("/admin/{id}/product/details", name="app_product_details")
 */
public function index($id, ProductDetailsRepository $productDetailsRepo, ProductRepository $productRepo): Response
{
    $product = $productRepo->find($id);

    $productDetails = $productDetailsRepo->findBy(['product' => $product]);

    return $this->render('admin/product_details/index.html.twig', [
        'productDetails' => $productDetails
    ]);
}

   /**
 * @Route("/admin/{id}/add-color", name="app_product_add_color", methods={"GET", "POST"})
 */
public function edit($id, Request $request,ProductDetails $productDetail, ProductDetailsRepository $productDetailRepo, ColorRepository $colorRepo, EntityManagerInterface $em): Response
{

    $form = $this->createForm(AddColorProductType::class, []);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $colors = $form->get('colors')->getData();
        foreach ($colors as $colorDetail) {
            $color = new Color();
            $color->setColor($colorDetail['color']); // Assurez-vous que 'color' est la bonne clé
            $productDetail->addColor($color);
            $em->persist($color);
        }
        
        

        $em->flush(); // Exécutez flush pour effectuer les opérations persist et flush

        $message = "La couleur a bien été enregistrée, merci pour votre confiance";

        $this->addFlash(
            'success',
            $message
        );

        return $this->redirectToRoute('app_product_details', [
            'id' => $productDetail->getProduct()->getId(),
        ], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('admin/product_details/add_color.html.twig', [
        'form' => $form,
    ]);
}


    /**
     * @Route("/admin/{id}", name="app_product_detail_delete", methods={"POST"})
     */
    public function delete(Request $request, ProductDetails $productDetails, ProductDetailsRepository $productDetailRepo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productDetails->getId(), $request->request->get('_token'))) {
            $productDetailRepo->remove($productDetails, true);
        }

        $message = "Le detail de produit a bien été supprimé, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );


        return $this->redirectToRoute('app_product_details', [
            'id' => $productDetail->getId(),
        ], Response::HTTP_SEE_OTHER);
    }

}
