<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\EditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @Route("/edit", name="edit")
     */
    public function index(AuthenticationUtils $authenticationUtils, EntityManagerInterface $em , Request $request ): Response
    {
        $user = new User();
        $form = $this->createForm(EditFormType::class, $user);
            $form->handleRequest($request);


            var_dump($form->isSubmitted());
            var_dump($form->isValid());
            var_dump($form->getData());

        if ($form->isSubmitted()) {
            //$article = $form->getData();
            //$em->persist($article);
            //$em->flush();
            //var_dump("ok");
            $this->addFlash('success', 'Article Created! Knowledge is power!');
        }



        //var_dump($form);
        //var_dump($em->findOneByEmail(  $lastUsername = $authenticationUtils->getLastUsername()));

        


        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
            'form' => $form->createView(),
        ]);
    }
}
