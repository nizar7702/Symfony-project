<?php

namespace App\Controller;

use App\Entity\UserSecurity;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new UserSecurity();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {   $repo=$this->getDoctrine()->getRepository(UserSecurity::class);
        $users=$repo->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/user/deleteuser/{id}", name="deleteuser")
     */
    public function deleteuser($id): Response{
        $repo=$this->getDoctrine()->getRepository(UserSecurity::class);
        $user=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();
        $repo=$this->getDoctrine()->getRepository(UserSecurity::class);
            $users=$repo->findAll();
        #return $this->render('product/product.html.twig', ['product' => $product,]);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/user/panier/{id}", name="panier")
     */
    public function panier($id): Response{
        $repo=$this->getDoctrine()->getRepository(UserSecurity::class);
        $product=$repo->find($id);
        #return $this->render('product/product.html.twig', ['product' => $product,]);
        return $this->render('user/panier.html.twig');
    }
    /**
     * @Route("/user/{id}/edituser", name="edituser")
     */
    public function edituser(UserSecurity $user,Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $repo=$this->getDoctrine()->getRepository(UserSecurity::class);
            $users=$repo->findAll();
            // do anything else you need here, like send an email

            return $this->render('user/index.html.twig', [
                'users' => $users,
            ]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
