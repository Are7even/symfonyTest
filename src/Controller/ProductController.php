<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{productId}/addToCart', name: 'add_product_to_cart', methods: ['GET'])]
    public function addToCart(int $productId, ProductRepository $productRepository): RedirectResponse
    {
        $session = $this->requestStack->getSession();
        $product = $productRepository->findOneBy(['id' => $productId]);
        $products = $session->get('products', []);

        if (!empty($products['productById' . $productId])) {
            $products['productById' . $productId]['quantity'] += 1;
        } else {
            $products['productById' . $productId] = [
                'product' => $product,
                'quantity' => 1,
            ];
        }
        $session->set('products', $products);

        return $this->redirectToRoute('app_product_show', ['id' => $productId], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{productId}/removeToCart', name: 'remove_product_to_cart', methods: ['GET'])]
    public function removeToCart(int $productId): RedirectResponse
    {
        $session = $this->requestStack->getSession();
        $products = $session->get('products', []);

        if (!empty($products['productById' . $productId])) {
            if ($products['productById' . $productId]['quantity'] === 1) {
                unset($products['productById' . $productId]);
                $session->set('products', $products);
                return $this->redirectToRoute('app_product_show', ['id' => $productId], Response::HTTP_SEE_OTHER);
            }

            $products['productById' . $productId]['quantity'] -= 1;
            $session->set('products', $products);
        }

        return $this->redirectToRoute('app_product_show', ['id' => $productId], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
