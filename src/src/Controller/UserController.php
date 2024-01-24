<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\CommonService;
use App\Transformer\UserTransformer;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(
        private ValidatorInterface $validator,
        private CommonService $commonService,
        private UserService $userService,
        private UserTransformer $userTransformer
    ) {}

    #[Route('', methods: ['POST'])]
    public function create(UserDto $userDto): JsonResponse
    {
        $errors = $this->validator->validate($userDto);

        if (count($errors)) {
            return new JsonResponse(
                ["errors" => $this->commonService->getValidationErrorMessages($errors)
            ]);
        }

        $user = $this->userService->create($userDto);

        return new JsonResponse($this->userTransformer->transform($user));
    }
}
