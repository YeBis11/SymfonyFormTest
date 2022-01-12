<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use http\Client\Request;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]

    public function index(\Symfony\Component\HttpFoundation\Request $request, \Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

        return $this->renderForm('register/index.html.twig', [
            'form' => $form,
        ]);
    }
}
