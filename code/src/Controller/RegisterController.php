<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wallet;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class RegisterController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;
    private User $user;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->user = new User();
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function registerPage(
        Request $request
    ): Response {
        $form = $this->createForm(RegisterFormType::class, $this->user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($form);
        }

        return $this->render(
            'register/registration.html.twig',
            [
                'controller_name' => 'RegisterController',
                'form' => $form->createView(),
            ]
        );
    }

    private function handleForm(FormInterface $form): Response
    {
        $this->registerPassword($form->get('plainPassword')->getData());
        $this->createWallet();

        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        return $this->redirectToRoute("home_page");
    }

    private function registerPassword(
        string $plainPassword
    ): void {
        $this->user->setPassword(
            $this->passwordEncoder->encodePassword($this->user, $plainPassword)
        );
    }

    private function createWallet(): void
    {
        $wallet = (new Wallet())
            ->setBalance(0);

        $this->user->setWallet($wallet);
    }
}
