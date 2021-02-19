<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountEditController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;
    private User $tempUser;
    private UserRepository $userRepository;
    private string $lastUserEmail;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        AuthenticationUtils $authenticationUtils,
        UserRepository $userRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->tempUser = new User();
        $this->userRepository = $userRepository;
        $this->lastUserEmail = $authenticationUtils->getLastUsername();
    }

    /**
     * @Route("/account/edit", name="account_edit_page")
     */
    public function accountEditPage(
        Request $request
    ): Response {
        $form = $this->createForm(RegisterFormType::class, $this->tempUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUserEdit($form);
        }

        return $this->render(
            'account/accountEdit.html.twig',
            [
                'controller_name' => 'AccountEditController',
                'form' => $form->createView(),
            ]
        );
    }

    private function handleUserEdit(FormInterface $form): ?Response
    {
        $user = $this->userRepository->findOneByEmail($this->lastUserEmail);

        if (!is_null($user)) {
            $user->setEmail($this->tempUser->getEmail());
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setLastname($this->tempUser->getLastname());
            $user->setFirstname($this->tempUser->getFirstname());
            $user->setBirthdate($this->tempUser->getBirthdate());
            $user->setCountryCode($this->tempUser->getCountryCode());
            $user->setTimeZone($this->tempUser->getTimeZone());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute("account_page");
        }

        return null;
    }
}
