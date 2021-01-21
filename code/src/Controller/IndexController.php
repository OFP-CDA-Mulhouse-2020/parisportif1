<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EventRepository $eventRepository): Response
    {
        $user = $this->getUser();
        $showAll = $eventRepository->findAll();

        for ($i = 0 ; $i < sizeof($showAll) ; $i++ )
        {
            dump($showAll[$i]);
        }
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'dbEvent' => $showAll,
        ]);
    }
}
