<?php

namespace App\Controller;

use App\Repository\OddsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BetController extends AbstractController
{
    /**
     * @Route("/bet/{id}", name="bet")
     */
    public function index(OddsRepository $oddsRepository): Response
    {
        $user = $this->getUser();
        $showAll = $oddsRepository->findAll();

        return $this->render('bet/index.html.twig', [
            'controller_name' => 'BetController',
        ]);
    }
}
