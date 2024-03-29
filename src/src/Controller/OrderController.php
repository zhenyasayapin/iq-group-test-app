<?php

namespace App\Controller;

use App\Dto\OrderCreateDto;
use App\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Service\CommonService;
use App\Service\OrderService;
use App\Transformer\OrderStatusTransformer;
use App\Transformer\OrderTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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

    #[Route('/all', methods: ['GET'])]
    #[IsGranted('ROLE_MANAGER')]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            array_map(
                fn(Order $order) => $this->orderTransformer->transform($order),
                $this->orderService->getAll()
            )
        );
    }

    #[Route('/my', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function currentUserIndex(): JsonResponse
    {
        return new JsonResponse(
            array_map(
                fn(Order $order) => $this->orderTransformer->transform($order),
                $this->orderService->getCurrentUserAll()
            )
        );
    }

    #[Route('/new', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(OrderCreateDto $orderDto): JsonResponse
    {
        $errors = $this->validator->validate($orderDto);

        if (count($errors) > 0) {

            return new JsonResponse([
                "error" => [
                    'messages' => $this->commonService->getValidationErrorMessages($errors)
                ]
            ]);
        }

        $order = $this->orderService->create($orderDto);

        return new JsonResponse($this->orderTransformer->transform($order));
    }

    #[Route('/{id}', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->findOne($id);

        return new JsonResponse($this->orderStatusTransformer->transform($order));
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    public function update($id, OrderUpdateDto $orderDto): JsonResponse
    {
        $errors = $this->validator->validate($orderDto);

        if (count($errors) > 0) {

            return new JsonResponse([
                "error" => [
                    'messages' => $this->commonService->getValidationErrorMessages($errors)
                ]
            ]);
        }

        $order = $this->orderService->update($id, $orderDto);

        return new JsonResponse($this->orderTransformer->transform($order));
    }
}
