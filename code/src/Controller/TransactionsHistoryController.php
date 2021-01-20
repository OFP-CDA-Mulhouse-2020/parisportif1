<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TransactionsHistoryController extends AbstractController
{
    /**
     * @Route("/transactions-history", name="transactions_history")
     */
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render(
            'transactions_history/index.html.twig',
            [
                'controller_name' => 'TransactionsHistoryController'
            ]
        );
    }
}
