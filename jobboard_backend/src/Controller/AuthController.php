<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher) // Injecter EntityManager et PasswordHasher
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json(['success' => false, 'message' => 'Email and password must be provided.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            return $this->json(['success' => false, 'message' => 'Invalid credentials.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        
        //generatedToken (check lexik_jwt_authe.yaml to see how JWT are generated)
        $token = $JWTManager->create($user);
        return $this->json(['token' => $token, 'success' => true]);
    }
}
