<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Form\AdminRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
   /**
     * @Route("/admin/register", name="app_register_admin")
     */
    public function register(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $em): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminRegistrationType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $password = $encoder->hashPassword($admin, $admin->getPassword());

            $roles = ["ROLE_ADMIN"];
            $admin->setRoles($roles);

            $admin->setPassword($password);

            // Persist the admin
            $em->persist($admin);
            $em->flush();

            //message flash
            $message = "Votre inscription a bien été enregistrée, vous pouvez connecter maintenant, merci pour votre confiance!!!";
            $this->addFlash(
                'success',
                $message
            );

            // Redirect to some success page
            return $this->redirectToRoute('app_connexion');
        }

        return $this->render('admin/account/register.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
