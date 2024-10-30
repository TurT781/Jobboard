<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
#[Route('/api')]
final class UsersController extends AbstractController
{
    #[Route('/registration', name: 'register_user', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $formData = json_decode($request->getContent(), true); // Get the JSON data

        
        if (!isset($formData['email'], $formData['first_name'], $formData['last_name'], $formData['phone_number'], $formData['password'])) {
            return $this->json(['success' => false, 'message' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
        }

        //check if the user is already exist
        $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['email' => $formData['email']]);
        if ($existingUser) {
            return $this->json(['success' => false, 'message' => 'Email already in use.'], Response::HTTP_CONFLICT);
        }

        $user = new Users();
        $user->setEmail($formData['email']);
        $user->setFirstName($formData['first_name']);
        $user->setLastName($formData['last_name']);
        $user->setPhoneNumber($formData['phone_number']);
        $user->setPassword($passwordHasher->hashPassword($user, $formData['password']));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['success' => true, 'message' => 'User registered successfully'], Response::HTTP_CREATED);
    }
}
