<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/property')]
class PropertyController extends AbstractController
{
    #[Route('/', name: 'property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setOwner($this->getUser());
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/like', name: 'property_like')]
    public function like(Request $request, EntityManagerInterface $entityManager): RedirectResponse|JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->isXmlHttpRequest()) {
            $propertyId = $request->request->get('propertyId');
            try {
                $property = $entityManager->getRepository(Property::class)->find($propertyId);
                $property->incrementLikes();
                $entityManager->flush();
            } catch (\Exception $exception) {
                return new JsonResponse(false);
            }
            return new JsonResponse(true);
        }
        return $this->redirectToRoute('index');
    }

    #[Route('/{id}', name: 'property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
    }
}
