<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/api/registration', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true); // Get the JSON data

        // Check if user data is provided
        if (!isset($data['userData'])) {
            return $this->json(['success' => false, 'message' => 'Invalid data.'], Response::HTTP_BAD_REQUEST);
        }

        $userData = $data['userData'];

        // Check if email and password are provided
        if (empty($userData['email']) || empty($userData['password'])) {
            return $this->json(['success' => false, 'message' => 'Email and password are required.'], Response::HTTP_BAD_REQUEST);
        }

        // Check if the user already exists
        $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['email' => $userData['email']]);
        if ($existingUser) {
            return $this->json(['success' => false, 'message' => 'User already exists.'], Response::HTTP_CONFLICT);
        }

        // Create the new user
        $user = new Users();
        $user->setFirstName($userData['first_name']);
        $user->setLastName($userData['last_name']);
        $user->setPhoneNumber($userData['phone_number']);
        $user->setEmail($userData['email']);
        $user->setPassword($userPasswordHasher->hashPassword($user, $userData['password']));

        // Save the new user to the database
        $entityManager->persist($user);

        try {
            $entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error while saving user.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Return success response
        return new JsonResponse(['message' => 'Registration successful!', 'user' => ['id' => $user->getId(), 'email' => $user->getEmail()]], Response::HTTP_CREATED);
    }
}
