<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function homePage(EventRepository $eventRepository): Response
    {
        return $this->render('home/homepage.html.twig', [
            'controller_name' => 'HomeController',
            'event_list' => $eventRepository->findAll()
        ]);
    }
}
