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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }


    // page d'accueil
    #[Route('/', name: 'accueil', methods: ['GET'])]
    public function index(AdsRepository $adsRepository): Response
    {
        // on récupère toutes les annonces avec leurs images
        $ads = $this->em->getRepository(Ads::class)->findAllWithImages();
        // dd($ads);
        return $this->render('home/home.html.twig', [
            'ads' => $ads
        ]);
    }

    // page des détails d'une annonce
    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id, Ads $ads)
    {
        // on récupère toutes les annonces avec leurs images
        $ads = $this->em->getRepository(Ads::class)->findByIdWithInfos($id);
        // on récupère l'id de l'utilisateur
        $user = $this->em->getRepository(User::class)->find($ads->getUserId());
        $reservation = new Reservation();
        // on donne a $reservation, l'id de l'utilisateur connecté
        $reservation->getUserId()->add($this->getUser());
        // dd($ads);
        return $this->render('home/detail.html.twig', [
            'ads' => $ads,
            'equipments' => $ads->getEquipmentId(),
            'user' => $ads->getUserId(),
            'form' => $this->createForm(ReservationType::class, $reservation)
        ]);
    }
}
