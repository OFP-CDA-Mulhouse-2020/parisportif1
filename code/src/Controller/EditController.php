<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @Route("/edit", name="edit")
     */
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(EditFormType::class, $user);
        $form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->render("base.html.twig");
        }*/



        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
            'form' => $form->createView(),
        ]);
    }
}
