<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account_page")
     */
    public function accountPage(): Response
    {
        return $this->render(
            'account/account.html.twig',
            [
                'controller_name' => 'AccountController',
            ]
        );
    }
}
