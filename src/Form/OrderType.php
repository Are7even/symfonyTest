<?php

namespace App\Form;

use App\Entity\Order;
use App\Services\OrderService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderType extends AbstractType
{
    private RequestStack $requestStack;
    private Order $order;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->order = new Order();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user');
//            ->add('total_price', textType::class, [
//                'label' => 'Sum',
//                'data' => (new OrderService($this->requestStack))->calculateSum()
//            ]);
    }

}
