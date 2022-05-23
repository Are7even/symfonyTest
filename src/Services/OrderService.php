<?php

namespace App\Services;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductToOrder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderService
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
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

    public function createProductToOrder(Product $product, Order $order, int $quantity, int $price, $doctrine): void
    {
        $manager = $doctrine->getManager();

        $productToOrder = new ProductToOrder();
        $productToOrder->setProduct($product);
        $productToOrder->setOrder($order);
        $productToOrder->setQuantity($quantity);
        $productToOrder->setPrice($price);

        $manager->merge($productToOrder);
        $manager->flush();
    }
}