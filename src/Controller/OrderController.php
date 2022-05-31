<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/index', name: 'app_order_index', methods: ['GET', 'POST'])]
    public function index(Request $request, OrderRepository $orderRepository, OrderService $orderService): Response
    {
        $order = new Order;
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $session = $orderService->requestStack->getSession();

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setTotalPrice($orderService->calculateSum());
            $orderService->add($order, $session);
            dump($order);die;
            $session->remove('products');
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/index.html.twig', [
            'form' => $form,
            'products' => $session->get('products')
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $orderRepository->remove($order, true);
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
