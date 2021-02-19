<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountHistoryController extends AbstractController
{
    /**
     * @Route("/account/history", name="account_history")
     */
    public function history(): Response
    {
        return $this->render(
            'account/history/history.html.twig',
            [
                'controller_name' => 'AccountHistoryController',
            ]
        );
    }
}
