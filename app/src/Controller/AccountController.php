<?php

namespace App\Controller;

use App\Repository\AdsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile()
    {
        return $this->render('account/profile.html.twig');
    }


    #[Route('/myads', name: 'myAds', methods: ['GET'])]
    public function myAds(AdsRepository $adsRepository): Response
    {
        return $this->render('account/myAds.html.twig', [
            'userId' => $adsRepository->findAllByUserId([$this->security->getUser()]),
        ]);
    }
}
