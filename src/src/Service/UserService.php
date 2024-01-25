<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Enum\Role;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher,
        private UserRepository $userRepository
    ) {}
    public function create(UserDto $userDto)
    {
        $user = $this->userRepository->findBy([
            'username' => $userDto->username
        ]);

        if ($user) {
            throw new \InvalidArgumentException('User with selected username already exists');
        }

        $user = new User();

        $password = $this->hasher->hashPassword($user, $userDto->plainPassword);

        $user->setPassword($password);
        $user->setUsername($userDto->username);
        $user->setRoles([Role::from($userDto->role)]);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
