<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{productId}', name: 'product_view')]
    public function view(int $productId)
    {
        return new Response('view');
    }

    #[Route('/product/create', name: 'product_create')]
    public function create()
    {
        return new Response('create');
    }

    #[Route('/product/update/{productId}', name: 'product_update')]
    public function update(int $productId)
    {
        return new Response('update');
    }

    #[Route('/product/delete/{productId}', name: 'product_delete')]
    public function delete(int $productId)
    {
        return new Response('delete');
    }
}