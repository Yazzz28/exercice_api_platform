<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(): User
    {
        $user = $this->getUser();
        
        if ($user instanceof JWTUser) {
            $user = $this->userRepository->findOneBy(['email' => $user->getUserIdentifier()]);
        }

        if (!$user instanceof User) {
            throw new \LogicException('The logged-in user is not an instance of App\Entity\User.');
        }

        return $user;
    }

    #[Route('api/me', methods: ['GET'])]
    public function login(Security $security): User
    {
        $user = $security->getUser();

        if ($user instanceof JWTUser) {
            $user = $this->userRepository->findOneBy(['email' => $user->getUserIdentifier()]);
        }

        if (!$user instanceof User) {
            throw new \LogicException('The logged-in user is not an instance of App\Entity\User.');
        }

        return $user;
    }

    #[Route('/me', methods: ['POST'])]
    public function logout(): void
    {
        // Add your logout logic here
    }
}
