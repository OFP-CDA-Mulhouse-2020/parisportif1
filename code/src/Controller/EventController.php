<?php

namespace App\Controller;

use App\Form\BetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event/{id<\d+>}", name="specific_event")
     */
    public function showSpecificEvent(Request $request, int $id): Response
    {
        return $this->render(
            'event/event.html.twig',
            [
                'controller_name' => basename(__FILE__, ".php")
            ]
        );
    }
}
