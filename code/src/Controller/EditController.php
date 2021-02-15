<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class EditController extends AbstractController
{
    private UserPasswordEncoderInterface $encode;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encode = $encoder;
    }

    /**
     * @Route("/account/edit", name="edit_account_page")
     */
    public function index(
        AuthenticationUtils $authenticationUtils,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $userTmp = new User();
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(EditFormType::class, $userTmp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $entityManager->getRepository(User::class)->findOneByEmail($authenticationUtils->getLastUsername());

            if ($user) {
                $user->setLastname($userTmp->getLastname());
                $user->setFirstname($userTmp->getFirstname());
                $user->setPassword(
                    $this->encode->encodePassword(
                        $userTmp,
                        $userTmp->getPassword()
                    )
                );
                $user->setBirthdate($userTmp->getBirthdate());
                $em->persist($user);
                $em->flush();
            }

            $this->addFlash('success', 'Article Created! Knowledge is power!');
        }

        return $this->render(
            'edit/index.html.twig',
            [
                'controller_name' => 'EditController',
                'form' => $form->createView(),
            ]
        );
    }
}
