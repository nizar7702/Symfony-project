<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserSecurity;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/panier/{id}", name="panier")
     */
    public function panier($id): Response{
        $repo=$this->getDoctrine()->getRepository(User::class);
        $product=$repo->find($id);
        #return $this->render('product/product.html.twig', ['product' => $product,]);
        return $this->render('user/panier.html.twig');
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
     * @Route("/user/adduser", name="adduser")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        // ...

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
            $repo=$this->getDoctrine()->getRepository(User::class);
            $users=$repo->findAll();
            
            return $this->render('user/index.html.twig', [
                'users' => $users,
            ]);
        }
        return $this->renderForm('user/newuser.html.twig', [
            'formpro' => $form,
        ]);
    }
}
