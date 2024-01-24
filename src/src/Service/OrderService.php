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
    private ?User $currentUser;
    public function __construct(
        private OrderRepository $orderRepository,
        private TokenStorageInterface $tokenStorage
    ) {
        $this->currentUser = $tokenStorage->getToken()->getUser();
    }

    public function create(OrderCreateDto $orderDto): Order
    {
        $order = new Order();

        $order->setMessage($orderDto->message);
        $order->setTopic($orderDto->topic);
        $order->setStatus(OrderStatus::NEW);
        $order->setUser($this->currentUser);

        $this->orderRepository->add($order, true);

        return $order;
    }

    public function getAll(): array
    {
        return $this->orderRepository->getAll();
    }

    public function getCurrentUserAll(): array
    {
        return $this->orderRepository->findBy(["user" => $this->currentUser->getId()]);
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
