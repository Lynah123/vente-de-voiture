<?php

namespace App\Controller\Front;

use App\Entity\Client;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form = $this->createForm(RegisterFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $password = $encoder->hashPassword($client, $client->getPassword());

            $roles = ["ROLE_USER"];
            $client->setRoles($roles);

            $client->setPassword($password);

            // Persist the client
            $em->persist($client);
            $em->flush();

            //message flash
            $message = "Votre inscription a bien été enregistrée, vous pouvez connecter maintenant, merci pour votre confiance!!!";
            $this->addFlash(
                'success',
                $message
            );

            // Redirect to some success page
            return $this->redirectToRoute('app_login');
        }

        return $this->render('front/account/register.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
