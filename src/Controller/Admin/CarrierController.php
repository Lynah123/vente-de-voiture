<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Form\CarrierType;
use App\Repository\CarrierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/carrier")
 */
class CarrierController extends AbstractController
{
    /**
     * @Route("/", name="app_carrier_index", methods={"GET"})
     */
    public function index(CarrierRepository $carrierRepository): Response
    {
        return $this->render('admin/carrier/index.html.twig', [
            'carriers' => $carrierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_carrier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CarrierRepository $carrierRepository): Response
    {
        $carrier = new Carrier();
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrierRepository->add($carrier, true);

            $message = "Le transporteur a bien été enregistré, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/carrier/new.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="app_carrier_show", methods={"GET"})
     */
    public function show(Carrier $carrier): Response
    {
        return $this->render('admin/carrier/show.html.twig', [
            'carrier' => $carrier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_carrier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Carrier $carrier, CarrierRepository $carrierRepository): Response
    {
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrierRepository->add($carrier, true);

            $message = "Le transporteur a bien été modifié, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/carrier/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_carrier_delete", methods={"POST"})
     */
    public function delete(Request $request, Carrier $carrier, CarrierRepository $carrierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carrier->getId(), $request->request->get('_token'))) {
            $carrierRepository->remove($carrier, true);

            $message = "Le transporteur a bien été supprimé, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );
        }

        return $this->redirectToRoute('app_carrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
