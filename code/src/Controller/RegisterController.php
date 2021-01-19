<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wallet;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        

        


        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        var_dump($user);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $walletUser = new Wallet();
            $walletUser
                ->setBalance(0)
                ->setUser($user);

            $user->setWallet($walletUser);
            $em->persist($user);
            $em->flush();

            return $this->render("base.html.twig");
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form' => $form->createView(),
        ]);
    }
}
