<?php

namespace App\Controller\Front;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductDetailsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/commande/liste", name="app_my_order")
     */
    public function myOrder(OrderRepository $orderRepo) 
    {
        $client = $this->getUser();
        $orders = $orderRepo->findByClient($client);
        return $this->render('front/order/my_order.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/commande", name="app_order")
     */
    public function index(Request $request, ProductDetailsRepository $productRepo, SessionInterface $session): Response
    {
        
        if(!$this->getUser()->getAdressesDelivery()->getValues()) {
            return $this->redirectToRoute('app_adresse_new');
        }

        $cart = $session->get("cart", []);

        if(!$cart) {
            return $this->redirectToRoute('app_cart');
        }

        $dataCart = [];

        foreach ($cart as $id => $quantity) {
            $productDetails = $productRepo->find($id);

            $dataCart[] = [
                'productDetail' => $productDetails,
                'quantity' => $quantity,
            ];
        }
        
        $form = $this->createForm(OrderType::class, null, [
            'client' => $this->getUser(),

        ]);

        return $this->render('front/order/index.html.twig', [
            'form' => $form->createVIew(),
            'dataCart' => $dataCart,
        ]);
    }

     /**
     * @Route("/commande/recapitulatif", name="app_order_recap")
     */
    public function add(SessionInterface $session, Request $request, ProductDetailsRepository $productRepo, EntityManagerInterface $em): Response
    {

        $cart = $session->get("cart", []);

        if (!$cart) {
            return $this->redirectToRoute('app_cart');
        }
    
        $dataCart = [];
    
        foreach ($cart as $id => $quantity) {
            $productDetails = $productRepo->find($id);
            
        
            $dataCart[] = [
                'productDetail' => $productDetails,
                'quantity' => $quantity,
            ];
            
        }
    
        $form = $this->createForm(OrderType::class, null, [
            'client' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $client = $this->getUser();

           $date = new \DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('adresses')->getData();

            $delivery_content = $delivery->getAdress(). '<br/>' .$delivery->getCity(). '<br/>' .$delivery->getPostal(). '<br/>' .$delivery->getPhone();
            if($delivery->getCompany()) {
                $delivery_content .= '<br/>' .$delivery->getCompany();
            }

            $order = new Order();

            $reference = $date->format('dmY').'-'.uniqId();
            $order->setReference($reference)
                  ->setCreatedAt($date)
                  ->setCarrierName($carriers->getName())
                  ->setCarrierPrice($carriers->getPrice())
                  ->setDelivery($delivery_content)
                  ->setIsPaid(0)
                  ->setClient($client)
                  ;

            $em->persist($order);

            foreach($dataCart as $cartItem) {
                $orderDetail = new OrderDetails();

                $orderDetail->setMyOrder($order)
                            ->setProduct($cartItem['productDetail']->getProduct()->getTitle())
                            ->setBrand($cartItem['productDetail']->getBrand()->getTitle())
                            ->setCategory($cartItem['productDetail']->getCategory()->getTitle())
                            ->setType($cartItem['productDetail']->getType()->getTitle())
                            ->setQuantity($cartItem['quantity'])
                            ->setPrice($cartItem['productDetail']->getPrice())
                            //->setColor($cartItem['productDetail']->getColors()->getColor())
                            ->setColor('bleu')
                            ->setTotal($cartItem['productDetail']->getPrice() * $cartItem['quantity'])
                            ;

                $quantityProduct_restant = $cartItem['productDetail']->getQuantity() - $cartItem['quantity'];

                $productDetails->setQuantity($quantityProduct_restant);

                if($productDetails->getQuantity() == 0) {
                    $productDetails->setIsOutOfStock(1);
                }

                $em->persist($orderDetail);
                $em->persist($productDetails);
                
            }

            $em->flush();

            $session->remove("cart");

            $message = "Votre commande a bien été enregistré, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_order_confirm', [
                'id' => $order->getId(),
            ]);


            return $this->render('front/order/add.html.twig', [
                'dataCart' => $dataCart,
                'carrier' => $carriers,
                'adresse' => $delivery_content,
                'reference' => $order->getReference(),
                'selectedColors' => $selectedColors,
            ]);
        }

        return $this->redirectToRoute('app_cart');
       
    }

     /**
     * @Route("/commande/{id}/confirmation", name="app_order_confirm")
     */
    public function confirm(Order $order) {

        return $this->render('front/order/confirm.html.twig', [
            'order' => $order,
        ]);
    }
}
