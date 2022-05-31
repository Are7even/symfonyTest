<?php

namespace App\Services;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductToOrder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderService
{
    public RequestStack $requestStack;
    private EntityManagerInterface $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function calculateSum(): int
    {
        $session = $this->requestStack->getSession();

        $sum = 0;
        if (!empty($session->get('products'))) {
            foreach ($session->get('products') as $key => $product) {
                $sum += $product['product']->getPrice() * $product['quantity'];
            }
        }

        return $sum;
    }

    private function calculatePrice($product): float|int
    {
        return $product['product']->getPrice() * $product['quantity'];
    }

    private function createProductToOrder(Product $product, Order $order, int $quantity, int $price): void
    {
        $productToOrder = new ProductToOrder();
        $productToOrder->setProduct($product);
        $productToOrder->setOrder($order);
        $productToOrder->setQuantity($quantity);
        $productToOrder->setPrice($price);

        $this->entityManager->merge($productToOrder);

        $order->addProductToOrder($productToOrder);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function add(Order $order, $session): void
    {
        foreach ($session->get('products') as $key => $product) {
            $price = $this->calculatePrice($product);
            $this->createProductToOrder($product['product'], $order, $product['quantity'], $price);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}