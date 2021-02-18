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
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegisterController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private User $user;


    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->validator = $validator;

        $this->user = new User();
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function registerPage(
        Request $request
    ): Response {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('home_page');
        }

        $form = $this->createForm(
            RegisterFormType::class,
            $this->user,
            ['validation_groups' => ["registerUser", 'Default']]
        );
        $form->handleRequest($request);

        if (
            $form->isSubmitted() &&
            $form->isValid() &&
            $this->handleForm($form)
        ) {
            $this->entityManager->persist($this->user);
            $this->entityManager->flush();
        }

        return $this->render(
            'register/registration.html.twig',
            [
                'controller_name' => 'RegisterController',
                'form' => $form->createView(),
            ]
        );
    }

    /** @return bool True if valid user false otherwise */
    private function handleForm(FormInterface $form): bool
    {
        $plainPassword = $form->get('plainPassword')->getData();

        $this->setUserPassword($plainPassword);
        $this->createUserWallet();

        $violationsList = $this->validator->validate(
            $this->user,
            null,
            ['registerUser', 'addPasswordToUser', 'addWalletToUser', 'Default']
        );

        return count($violationsList) === 0;
    }

    private function setUserPassword(
        string $plainPassword
    ): void {
        $this->user->setPassword(
            $this->passwordEncoder->encodePassword($this->user, $plainPassword)
        );
    }

    private function createUserWallet(): void
    {
        $wallet = (new Wallet())
            ->setBalance(0);

        $this->user->setWallet($wallet);
    }
}
