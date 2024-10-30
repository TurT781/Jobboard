<?php

namespace App\Controller;

use App\Entity\Applications;
use App\Form\ApplicationsType;
use App\Repository\ApplicationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/applications')]
final class ApplicationsController extends AbstractController
{
    #[Route(name: 'app_applications_index', methods: ['GET'])]
    public function index(ApplicationsRepository $applicationsRepository): Response
    {
        return $this->json($applicationsRepository->findAll(), Response::HTTP_OK); // Return all applications
    }

    #[Route('/new', name: 'app_applications_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $application = new Applications();
        $form = $this->createForm(ApplicationsType::class, $application);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the new application
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->json(['success' => true, 'message' => 'Application created successfully.'], Response::HTTP_CREATED);
        }

        return $this->json(['success' => false, 'message' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_applications_show', methods: ['GET'])]
    public function show(Applications $application): Response
    {
        // Return application details
        return $this->json($application, Response::HTTP_OK);
    }

    #[Route('/{id}/edit', name: 'app_applications_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Applications $application, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApplicationsType::class, $application);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Save changes to the application
            $entityManager->flush();

            return $this->json(['success' => true, 'message' => 'Application updated successfully.'], Response::HTTP_OK);
        }

        return $this->json(['success' => false, 'message' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_applications_delete', methods: ['POST'])]
    public function delete(Request $request, Applications $application, EntityManagerInterface $entityManager): Response
    {
        // Check if the CSRF token is valid before deleting
        if ($this->isCsrfTokenValid(
            'delete' . $application->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($application);
            $entityManager->flush();
        }

        return $this->json(['success' => true, 'message' => 'Application deleted successfully.'], Response::HTTP_OK);
    }
}
