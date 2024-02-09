<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/admin/order", name="app_order_admin")
     */
    public function index(OrderRepository $orderRepo): Response
    {
        $orders = $orderRepo->findAll();

        return $this->render('admin/order/index.html.twig', [
            'orders' => $orders
        ]);
    }

     /**
     * @Route("/admin/{id}", name="app_order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('admin/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/admin/{id}", name="app_order_delete", methods={"POST"})
     */
    public function delete(Request $request, Order $order, OrderRepository $orderRepo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $orderRepo->remove($order, true);

            $message = "Le transporteur a bien été supprimé, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );
        }

        return $this->redirectToRoute('app_order_admin', [], Response::HTTP_SEE_OTHER);
    }
}
