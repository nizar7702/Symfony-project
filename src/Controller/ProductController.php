<?php

namespace App\Controller;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product2;
use App\Form\ProductType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {   $repo=$this->getDoctrine()->getRepository(Product2::class);
        $products=$repo->findAll();
        #$products=["article1","article2","article3"];
        return $this->render('product/product.html.twig', [
            'products' => $products,
        ]);
    }
    /**
     * @Route("/product/add", name="add")
     */
    public function add(): Response
    {   $manager=$this->getDoctrine()->getManager();
        $product = new Product2();
        $product->setLib("libtest")
            ->setPru(500)
            ->setDescription("testdescription de l'article")
            ->setIm("http://placehold.it/350*150");
        $manager->persist($product);

    $manager->flush();
        return new Response("ajout validé".$product->getId());
    }
    /**
     * @Route("/product/detail/{id}", name="detail")
     */
    public function detail($id): Response{
        $repo=$this->getDoctrine()->getRepository(Product2::class);
        $product=$repo->find($id);
        #return $this->render('product/product.html.twig', ['product' => $product,]);
        return $this->render('product/detail.html.twig', ['product' => $product]);
    }
    /**
     * @Route("/product/delete/{id}", name="delete")
     */
    public function delete($id): Response{
        $repo=$this->getDoctrine()->getRepository(Product2::class);
        $product=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();
        $repo=$this->getDoctrine()->getRepository(Product2::class);
            $products=$repo->findAll();
        #return $this->render('product/product.html.twig', ['product' => $product,]);
        return $this->render('product/product.html.twig', [
            'products' => $products,
        ]);
    }
    /**
     * @Route("/product/add2", name="add2")
     */
    public function new(Request $request): Response
    {
        $prod = new Product2();
        // ...

        $form = $this->createForm(ProductType::class, $prod);
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
            $repo=$this->getDoctrine()->getRepository(Product2::class);
            $products=$repo->findAll();
            
            return $this->render('product/product.html.twig', [
                'products' => $products,
            ]);
        }
        return $this->renderForm('product/new.html.twig', [
            'formpro' => $form,
        ]);
    }
    /**
     * @Route("/product/{id}/edit", name="edit")
     */
    public function edit(Product2 $prod,Request $request,$id): Response
    {
        $form = $this->createForm(ProductType::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $prod = $form->getData();
            

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prod); 
            $entityManager->flush();
            $repo=$this->getDoctrine()->getRepository(Product2::class);
            $product=$repo->find($id);
            return $this->render('product/detail.html.twig', [
                'product' => $product,
            ]);
        }
        return $this->renderForm('product/new.html.twig', [
            'formpro' => $form,
        ]);
    }
    
}
