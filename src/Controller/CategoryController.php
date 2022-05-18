<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/', name: 'category_index')]
    public function index()
    {


        return $this->render('category/index.html.twig', [

        ]);
    }

    #[Route('/category/{categoryId}', name: 'category_view')]
    public function view(int $categoryId)
    {
        return $this->render('category/view.html.twig', [

        ]);
    }

    #[Route('/category/create', name: 'category_create')]
    public function create()
    {
        
        return $this->render('category/create.html.twig');
    }

    #[Route('/category/update/{categoryId}', name: 'category_update')]
    public function update(int $categoryId)
    {
        return $this->render('category/update.html.twig', [

        ]);
    }

    #[Route('/category/delete/{categoryId}', name: 'category_delete')]
    public function delete(int $categoryId)
    {
        return $this->render('category/index.html.twig', [

        ]);
    }
}