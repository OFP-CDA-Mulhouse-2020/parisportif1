<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountWalletController extends AbstractController
{
    /**
     * @Route("/account/wallet", name="account_wallet")
     */
    public function index(): Response
    {
        return $this->render(
            'account/wallet/wallet.html.twig',
            [
                'controller_name' => 'AccountWalletController',
            ]
        );
    }
}
