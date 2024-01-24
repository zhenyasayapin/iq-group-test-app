<?php

namespace App\Service\Transformer;

use App\Entity\Order;

class OrderTransformer
{
    public function transform(Order $order): array
    {
        return [
            'id' => $order->getId(),
            'topic' => $order->getTopic(),
            'message' => $order->getMessage(),
            'status' => $order->getStatus(),
            'comment' => $order->getComment(),
            'createdAt' => $order->getCreatedAt(),
            'userId' => $order->getUser()->getId(),
        ];
    }
}
