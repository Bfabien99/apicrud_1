<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractApiController
{
    private $em;
    private $productsRepository;
    public function __construct(ProductsRepository $productsRepository, EntityManagerInterface $em){
        $this->productsRepository = $productsRepository;
        $this->em = $em;
    }

    #[Route('/api/v1', name: 'apiHome')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'CRUD API WITH SYMFONY #1',
            'author' => 'bfabien99',
            'email' => 'fabienbrou99@gmail.com',
            'date' => 'Monday 25th July 2022 - 03:34 PM'
        ]);
    }

    #[Route('/api/v1/products', name: 'app_products', methods : ['GET'])]
    public function getProducts(): Response
    {
        $products = $this->productsRepository->findAll();
        $length = count($products);
        serialize($products);
       
        return $this->json([
            "message" => "All products in database",
            "status" => "200",
            "length" => $length,
            "data" => $products
        ]);
    }

    #[Route('/api/v1/product', name: 'app_create_product', methods : ['POST'])]
    public function createProduct(Request $request): Response
    {   
        $form = $this->buildForm(ProductType::class);
        $form->handleRequest($request);
        
        if(!$form->isSubmitted() || !$form->isValid()) {
            //throw error
            return $this->json($form);
            exit;
        }

        $product = $form->getData();
        serialize($product);

        $this->em->persist($product);
        $this->em->flush();

        return $this->json([
            "message" => "New product created!",
            "status" => "201",
            "data" => $product
        ]);
    }

    #[Route('/api/v1/product/{id}', name: 'app_show_product', methods : ['GET'])]
    public function showProduct($id): Response
    {
        $product = $this->productsRepository->find($id);
        if(!$product){
            return $this->json([
                "message" => "Product with id = $id doesn't exist!",
                "status" => "401",
                "data" => []
            ]);
            exit;
        }

        serialize($product);
       
        return $this->json([
            "message" => "Product exist!",
            "status" => "200",
            "data" => $product
        ]);
    }

    #[Route('/api/v1/product/{id}', name: 'app_update_product', methods : ['POST'])]
    public function updateProduct($id, Request $request): Response
    {   
        $product = $this->productsRepository->find($id);
        if(!$product){
            return $this->json([
                "message" => "Product with id = $id doesn't exist!",
                "status" => "401",
                "data" => []
            ]);
            exit;
        }

        $form = $this->buildForm(ProductType::class);
        $form->handleRequest($request);
        
        if(!$form->isSubmitted() || !$form->isValid()) {
            //throw error
            return $this->json($form);
            exit;
        }

        $product->setTitle($form->get('title')->getData());
        $product->setDescription($form->get('description')->getData());
        $product->setPrice($form->get('price')->getData());
        $product->setImageUrl($form->get('image_url')->getData());
        serialize($product);

        $this->em->flush();

        return $this->json([
            "message" => "Product updated!",
            "status" => "201",
            "data" => $product
        ]);
    }

    #[Route('/api/v1/product/{id}', name: 'app_delete_product', methods : ['DELETE'])]
    public function deleteProduct($id): Response
    {
        $product = $this->productsRepository->find($id);

        if(!$product){
            return $this->json([
                "message" => "Product with id = $id doesn't exist!",
                "status" => "401",
                "data" => []
            ]);
            exit;
        }

        $this->em->remove($product);
        $this->em->flush();
       
        return $this->json([
            "message" => "Product delete!",
            "status" => "200",
            "data" => $product
        ]);
    }
}
