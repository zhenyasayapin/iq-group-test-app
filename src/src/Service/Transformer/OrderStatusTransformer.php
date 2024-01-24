<?php

namespace App\Service\Transformer;

use App\Entity\Order;

class OrderStatusTransformer
{
    public function __construct()
    {}
    public function transform(Order $order)
    {
        return [
            'id' => $order->getId(),
            'status' => $order->getStatus()
        ];
    }
}
