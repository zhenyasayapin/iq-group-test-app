<?php

namespace App\Controller\ArgumentValueResolver;

use App\Entity\Dto\AbstractDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValueResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    public function supports(ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), AbstractDto::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->createFromRequest($request, $argument);
    }

    private function createFromRequest(Request $request, ArgumentMetadata $argument): AbstractDto
    {
        return $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
    }
}
