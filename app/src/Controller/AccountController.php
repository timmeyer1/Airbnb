<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile()
    {
        return $this->render('account/profile.html.twig');
    }

    #[Route('/myads', name: 'myAds', methods: ['GET'])]
    public function myAds()
    {
        return $this->render('account/myAds.html.twig');
    }
}
