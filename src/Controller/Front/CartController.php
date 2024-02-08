<?php

namespace App\Controller\Front;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepo): Response
    {
        $cart = $session->get("cart", []);

        // on "fabrique" les données

        $dataCart = [];

        foreach($cart as $id => $quantity) {
            $product = $productRepo->find($id);

            $dataCart[] = [
                'product' => $product,
                'quantity' => $quantity
            ];

        }

        return $this->render('front/cart/index.html.twig', [
            'dataCart' => $dataCart
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="app_cart_add")
     */
    public function add(Product $produit, SessionInterface $session)
    {
        //on récupère le panier actuel

        $cart = $session->get("cart", []);

        $id = $produit->getId();

        $limit = $produit->getQuantity();

        if((!empty($cart[$id]))) {

            if($cart[$id] < $limit) {

                $cart[$id]++;

            }
           
        } else {
            $cart[$id] = 1;
        }

        // on sauvegarde dans la session

        $session->set("cart", $cart);

        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/remove/{id}", name="app_cart_remove")
     */
    public function remove(Product $produit, SessionInterface $session)
    {
        //on récupère le panier actuel

        $cart = $session->get("cart", []);

        $id = $produit->getId();


        if(!empty($cart[$id])) {

            if($cart[$id] > 1) {

            $cart[$id]--;

            } else {
                unset($cart[$id]);
            }
        } 

        // on sauvegarde dans la session

        $session->set("cart", $cart);

        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/delete/{id}", name="app_cart_delete")
     */
    public function delete(Product $produit, SessionInterface $session)
    {
        //on récupère le panier actuel

        $cart = $session->get("cart", []);

        $id = $produit->getId();

        if(!empty($cart[$id])) {

                unset($cart[$id]);
        } 

        // on sauvegarde dans la session

        $session->set("cart", $cart);

        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/supprimer", name="app_cart_supprimer")
     */
    public function deleteAll(SessionInterface $session)
    {

        $session->remove("cart");

        return $this->redirectToRoute('app_cart');

    }
}
