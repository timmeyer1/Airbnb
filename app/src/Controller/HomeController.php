<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Equipment;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\AdsRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em){}


    #[Route('/', name: 'accueil', methods: ['GET'])]
    public function index(AdsRepository $adsRepository): Response
    {
        $ads = $this->em->getRepository(Ads::class)->findAllWithImages();
        // dd($ads);
        return $this->render('home/home.html.twig', [
            'ads' => $ads
        ]);
    }

    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id, Ads $ads, Request $request, EntityManagerInterface $entityManager): Response
    {
        $ads = $this->em->getRepository(Ads::class)->findByIdWithInfos($id);
        $user = $this->em->getRepository(User::class)->find($ads->getUserId());

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            Response::HTTP_SEE_OTHER;
        }
        // dd($ads);
        return $this->render('home/detail.html.twig', [
            'ads' => $ads,
            'equipments' => $ads->getEquipmentId(),
            'user' => $ads->getUserId(),
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }


}
