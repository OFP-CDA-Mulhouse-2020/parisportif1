<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Entity\User;
use App\Entity\Odds;
use App\Repository\BetRepository;
use App\Form\BetType;
use App\Repository\OddsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BetController extends AbstractController
{
    /**
     * @Route("/bet/{id}", name="bet")
     */
    public function index(Request $request, OddsRepository $oddsRepository,  $id): Response
    {
        $user = $this->getUser();

        $bet = new Bet();
        $userBet = new User();
        $odds = new Odds();

        //dump($user.id);
        $oddsDbByIdPage = $oddsRepository->findBy(['event' => $id]);

        $form = $this->createForm(BetType::class, $bet);
        $form->handleRequest($request);

        $extraData = $form->getExtraData();
        
        dump($form);

        dump($bet->getOdds());

        if ($form->isSubmitted() && $form->isValid()) {
            $oddsDb = $oddsRepository->findBy(['event' => json_decode(json_encode($extraData))->odds]);

            //$bet->setOdds(json_decode(json_encode($extraData))->odds); 
            //$bet->setUser($user.id);
            //$em->persist($bet);
            //$em->flush();
        }
 

        return $this->render('bet/index.html.twig', [
            'controller_name' => 'BetController',
            'form' => $form->createView(),
            'odds' => $oddsDbByIdPage
            
        ]);
        
    }
}
