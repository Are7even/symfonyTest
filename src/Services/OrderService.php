<?php

namespace App\Services;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductToOrder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderService
{
    public RequestStack $requestStack;
    private ManagerRegistry $doctrine;

    public function __construct(RequestStack $requestStack, ManagerRegistry $doctrine)
    {
        $this->requestStack = $requestStack;
        $this->doctrine = $doctrine;
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

    public function calculatePrice($product): float|int
    {
        return $product['product']->getPrice() * $product['quantity'];
    }

    public function createProductToOrder(Product $product, Order $order, int $quantity, int $price): void
    {
        $manager = $this->doctrine->getManager();

        $productToOrder = new ProductToOrder();
        $productToOrder->setProduct($product);
        $productToOrder->setOrder($order);
        $productToOrder->setQuantity($quantity);
        $productToOrder->setPrice($price);

        $manager->merge($productToOrder);
        $manager->flush();
    }
}