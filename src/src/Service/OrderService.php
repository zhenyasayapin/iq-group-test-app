<?php

namespace App\Service;

use App\Entity\Dto\OrderCreateDto;
use App\Entity\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Repository\OrderRepository;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function create(OrderCreateDto $orderDto)
    {
        $order = new Order();

        $order->setMessage($orderDto->message);
        $order->setTopic($orderDto->topic);
        $order->setStatus(OrderStatus::NEW);

        $this->orderRepository->add($order, true);

        return $order;
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function findOne(int $id)
    {
        return $this->orderRepository->findOne($id);
    }

    public function update($id, OrderUpdateDto $orderDto)
    {
        $order = $this->orderRepository->findOne($id);

        $order->setStatus(OrderStatus::from($orderDto->status));
        $order->setComment($orderDto->comment);

        $this->orderRepository->add($order, true);

        return $order;
    }
}
