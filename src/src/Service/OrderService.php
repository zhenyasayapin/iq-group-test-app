<?php

namespace App\Service;

use App\Entity\Dto\OrderCreateDto;
use App\Entity\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderService
{
    private ?User $user;
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function create(OrderCreateDto $orderDto): Order
    {
        $order = new Order();

        $order->setMessage($orderDto->message);
        $order->setTopic($orderDto->topic);
        $order->setStatus(OrderStatus::NEW);

        $this->orderRepository->add($order, true);

        return $order;
    }

    public function getAll(): array
    {
        return $this->orderRepository->getAll();
    }

    public function findOne(int $id): ?Order
    {
        return $this->orderRepository->findOne($id);
    }

    public function update($id, OrderUpdateDto $orderDto): Order
    {
        $order = $this->orderRepository->findOne($id);

        $order->setStatus(OrderStatus::from($orderDto->status));
        $order->setComment($orderDto->comment);

        $this->orderRepository->add($order, true);

        return $order;
    }
}
