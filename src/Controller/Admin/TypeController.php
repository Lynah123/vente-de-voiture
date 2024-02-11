<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/type")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="app_type_index", methods={"GET"})
     */
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->render('admin/type/index.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeRepository $typeRepository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->add($type, true);

            $message = "Le type a bien été enregistré, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );


            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/type/new.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_show", methods={"GET"})
     */
    public function show(Type $type): Response
    {
        return $this->render('admin/type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->add($type, true);

            $message = "Le type a bien été modifié, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );


            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_delete", methods={"POST"})
     */
    public function delete(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $typeRepository->remove($type, true);
        }

        $message = "Le type a bien été supprimé, merci pour votre confiance";

            $this->addFlash(
                'success',
                $message
            );


        return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
