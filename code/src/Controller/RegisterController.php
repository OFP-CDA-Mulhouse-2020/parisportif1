<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wallet;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController extends AbstractController
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encode = $encoder;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $userRegister = new User();
        $user = $this->getUser();





        $form = $this->createForm(RegisterFormType::class, $userRegister);
        $form->handleRequest($request);

        var_dump($userRegister);

        if ($form->isSubmitted() && $form->isValid()) {
            $walletUser = new Wallet();
            $walletUser
                ->setBalance(0)
                ->setUser($userRegister);

            $userRegister->setWallet($walletUser);
            $userRegister->setPassword($this->encode->encodePassword(
                $userRegister,
                $userRegister->getPassword()
            ));
            $em->persist($userRegister);
            $em->flush();

            return $this->redirect('/', 301);
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form' => $form->createView(),
        ]);
    }
}
