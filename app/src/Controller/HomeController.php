<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\Image;
use App\Repository\AdsRepository;
use Doctrine\ORM\EntityManagerInterface;
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


    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile()
    {
        return $this->render('account/profile.html.twig');
    }

    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id)
    {
        $ads = $this->em->getRepository(Ads::class)->find($id);
        return $this->render('home/detail.html.twig', [
            'id' => $id
        ]);
    }
}
