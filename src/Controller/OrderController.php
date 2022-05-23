<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    private RequestStack $requestStack;


    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/index', name: 'app_order_index', methods: ['GET', 'POST'])]
    public function index(Request $request, OrderRepository $orderRepository): Response
    {
        $orderService = new OrderService($this->requestStack);
        $order = new Order;
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $session = $this->requestStack->getSession();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getTotalPrice() !== $orderService->calculateSum())
                $order->setTotalPrice($orderService->calculateSum());

            $orderRepository->add($order, true);
            foreach ($session->get('products') as $key => $product) {
                $price = $product['product']->getPrice() * $product['quantity'];
                $orderService->createProductToOrder($product['product'], $order, $product['quantity'], $price, $this->getDoctrine());
                $session->remove('products');
            }
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
