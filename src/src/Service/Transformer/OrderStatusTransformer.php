<?php

namespace App\Service\Transformer;

use App\Entity\Order;

class OrderStatusTransformer
{
    public function transform(Order $order): array
    {
        return [
            'id' => $order->getId(),
            'status' => $order->getStatus()
        ];
    }
}
