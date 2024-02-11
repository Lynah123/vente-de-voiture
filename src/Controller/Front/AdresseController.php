<?php

namespace App\Controller\Front;

use App\Entity\Adresse;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/adresse")
 */
class AdresseController extends AbstractController
{
    /**
     * @Route("/", name="app_adresse_index", methods={"GET"})
     */
    public function index(AdresseRepository $adresseRepository): Response
    {
        $client = $this->getUser();
        $adresses = $adresseRepository->findByClient($client);

        return $this->render('front/adresse/index.html.twig', [
            'adresses' => $adresses,
        ]);
    }

    /**
     * @Route("/new", name="app_adresse_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AdresseRepository $adresseRepository, SessionInterface $session): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $this->getUser();
            $adresse->setClient($client);

            $adresseRepository->add($adresse, true);

            $message = "Votre adrese de livraison a bien été enregistré, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );

            $cart = $session->get("cart", []);

            if($cart) {
                return $this->redirectToRoute('app_order', [], Response::HTTP_SEE_OTHER);
            } else {
            return $this->redirectToRoute('app_adresse_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('front/adresse/new.html.twig', [
            'adresse' => $adresse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adresse_show", methods={"GET"})
     */
    public function show(Adresse $adresse): Response
    {
        return $this->render('front/adresse/show.html.twig', [
            'adresse' => $adresse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_adresse_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Adresse $adresse, AdresseRepository $adresseRepository): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresseRepository->add($adresse, true);

            return $this->redirectToRoute('app_adresse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/adresse/edit.html.twig', [
            'adresse' => $adresse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adresse_delete", methods={"POST"})
     */
    public function delete(Request $request, Adresse $adresse, AdresseRepository $adresseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
            $adresseRepository->remove($adresse, true);
        }

        return $this->redirectToRoute('app_adresse_index', [], Response::HTTP_SEE_OTHER);
    }
}
