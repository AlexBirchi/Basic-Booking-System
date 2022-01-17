<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'checkout')]
    public function checkout(Room $room, ReservationRepository $reservationRepository, $stripeSK): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $checkIn = new \DateTime('Mon, 23 Jan 2022 12:00:00');
        $checkOut = new \DateTime('Fri, 27 Jan 2022 12:00:00');

        if ($checkIn->getTimestamp() > $checkOut->getTimestamp()) {
            $this->addFlash('danger', 'Invalid reservation interval.');
            return $this->redirectToRoute('property_index');
        }

        if ($checkIn->getTimestamp() < time()) {
            $this->addFlash('danger', 'Reservation must be done in a future time.');
            return $this->redirectToRoute('property_index');
        }

        $isAvailable = $reservationRepository->checkRoomAvailability($room, $checkIn, $checkOut);

        if (!$isAvailable) {
            $this->addFlash('danger', 'We are sorry, the room is not available at the selected time.');
            return $this->redirectToRoute('property_index');
        }

        Stripe::setApiKey($stripeSK);

        try {
            $checkoutSession = Session::create([
                'mode' => 'payment',
                'payment_method_types' => [
                    'card'
                ],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $room->getProperty()->getName() . ' - ' . $room->getRoomType()->getName(),
                        ],
                        'unit_amount' => $room->getBasePrice(),
                    ],
                    'quantity' => 1,
                ]],
                'success_url' => $this->generateUrl(
                    'success_url',
                    [
                        'id' => $room->getId(),
                        'checkIn' => $checkIn->getTimestamp(),
                        'checkOut' => $checkOut->getTimestamp(),
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            return $this->redirect($checkoutSession->url, 303);
        } catch (ApiErrorException $e) {
            $this->addFlash('danger', 'Something went wrong.');
            return $this->redirectToRoute('index');
        }
    }

    #[Route('/success-url/{id}/{checkIn}/{checkOut}', name: 'success_url')]
    public function successUrl(Room $room, $checkIn, $checkOut, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $checkInDate = new \DateTime();
        $checkInDate->setTimestamp($checkIn);
        $checkOutDate = new \DateTime();
        $checkOutDate->setTimestamp($checkOut);

        $reservation = new Reservation(
            $this->getUser(),
            $room,
            $checkInDate,
            $checkOutDate
        );

        try {
            $entityManager->persist($reservation);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Something went wrong.');
            return $this->redirectToRoute('index');
        }

        $this->addFlash('success', 'Your reservation has been placed!');
        return $this->redirectToRoute('property_index');
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->addFlash('danger', 'Payment failed while trying to place your reservation.');
        return $this->redirectToRoute('property_index');
    }
}
