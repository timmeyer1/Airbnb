<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    // route pour afficher les réservations créées
    #[Route('/index', name: 'reservationIndex', methods: ['GET'])]
    
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }


    // fonction pour ajouter une nouvelle réservation
    #[Route('/new', name: 'reservationNew', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        // $reservation->getUserId()->add($this->getUser()); // on ajoute l'id de l'utilisateur connecté
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservationList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    // fonction pour montrer une reservation (remplacée par "reservationList" dans homeController)
    // #[Route('/{id}', name: 'reservationShow', methods: ['GET'])]
    // public function show(Reservation $reservation): Response
    // {
    //     return $this->render('reservation/show.html.twig', [
    //         'reservation' => $reservation,
    //     ]);
    // }

    // fonction pour éditer une reservation
    #[Route('/{id}/edit', name: 'reservationEdit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reservationList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    // fonction pour supprimer une réservation
    #[Route('/{id}/delete', name: 'reservationDelete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // dd($reservation);
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservationList', [], Response::HTTP_SEE_OTHER);
    }
}
