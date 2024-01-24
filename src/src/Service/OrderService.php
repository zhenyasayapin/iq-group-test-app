<?php

namespace App\Service;

use App\Dto\OrderCreateDto;
use App\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Enum\OrderStatus;
use App\Entity\User;
use App\Enum\Role;
use App\Repository\OrderRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
        $order = $this->orderRepository->findOne($id);

        if (
            !in_array(Role::ROLE_MANAGER->value, $this->currentUser->getRoles())
            && $order->getUser()->getId() != $this->currentUser->getId()
        ) {
            throw new AccessDeniedException();
        }

        return $order;
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
