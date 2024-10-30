<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Form\AdvertisementsType;
use App\Repository\AdvertisementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/advertisements')]
final class AdvertisementsController extends AbstractController
{
    #[Route(name: 'app_advertisements_index', methods: ['GET'])]
    public function index(AdvertisementsRepository $advertisementsRepository): Response
    {
        return $this->json($advertisementsRepository->findAll(), Response::HTTP_OK); // Return all advertisements
    }

    #[Route('/new', name: 'app_advertisements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $advertisement = new Advertisements();
        $form = $this->createForm(AdvertisementsType::class, $advertisement);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the new advertisement
            $entityManager->persist($advertisement);
            $entityManager->flush();

            return $this->json(['success' => true, 'message' => 'Advertisement created successfully.'], Response::HTTP_CREATED);
        }

        return $this->json(['success' => false, 'message' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_advertisements_show', methods: ['GET'])]
    public function show(Advertisements $advertisement): Response
    {
        // Return advertisement details
        return $this->json($advertisement, Response::HTTP_OK);
    }

    #[Route('/{id}/edit', name: 'app_advertisements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Advertisements $advertisement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdvertisementsType::class, $advertisement);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Save changes to the advertisement
            $entityManager->flush();

            return $this->json(['success' => true, 'message' => 'Advertisement updated successfully.'], Response::HTTP_OK);
        }

        return $this->json(['success' => false, 'message' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_advertisements_delete', methods: ['DELETE'])]
    public function delete(Request $request, Advertisements $advertisement, EntityManagerInterface $entityManager): Response
    {
        // Check if the CSRF token is valid before deleting
        if ($this->isCsrfTokenValid('delete' . $advertisement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($advertisement);
            $entityManager->flush();

            return $this->json(['success' => true, 'message' => 'Advertisement deleted successfully.'], Response::HTTP_OK);
        }

        return $this->json(['success' => false, 'message' => 'Invalid CSRF token.'], Response::HTTP_BAD_REQUEST);
    }
}
