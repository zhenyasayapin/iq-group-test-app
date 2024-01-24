<?php

namespace App\Controller;

use App\Entity\Dto\OrderCreateDto;
use App\Entity\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Service\CommonService;
use App\Service\OrderService;
use App\Service\Transformer\OrderStatusTransformer;
use App\Service\Transformer\OrderTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

#[Route('/api/orders')]
class OrderController extends AbstractController
{
    public function __construct(
        private OrderService $orderService,
        private SerializerInterface $serializer,
        private OrderStatusTransformer $orderStatusTransformer,
        private OrderTransformer $orderTransformer,
        private ValidatorInterface $validator,
        private CommonService $commonService
    ) {}

    #[Route('/', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            array_map(
                fn(Order $order) => $this->orderTransformer->transform($order),
                $this->orderService->getAll()
            )
        );
    }

    #[Route('/new', methods: ['POST'])]
    public function new(OrderCreateDto $orderDto): JsonResponse
    {
        $errors = $this->validator->validate($orderDto);

        if (count($errors) > 0) {

            return new JsonResponse([
                "errors" => $this->commonService->getValidationErrorMessages($errors)
            ]);
        }

        $order = $this->orderService->create($orderDto);

        return new JsonResponse($this->orderTransformer->transform($order));
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->findOne($id);

        return new JsonResponse($this->orderStatusTransformer->transform($order));
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update($id, OrderUpdateDto $orderDto): Response
    {
        $errors = $this->validator->validate($orderDto);

        if (count($errors) > 0) {

            return new JsonResponse([
                "errors" => $this->commonService->getValidationErrorMessages($errors)
            ]);
        }

        $order = $this->orderService->update($id, $orderDto);

        return new JsonResponse($this->orderTransformer->transform($order));
    }
}
