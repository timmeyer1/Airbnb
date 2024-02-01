<?php

namespace App\Controller;

use App\Entity\Ads;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like/ad/{id}', name: 'likeAd', methods: ['GET'])]
    public function like(Ads $ad, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if($ad->isLikedByUser($user)) {
            $ad->removeLike($user);
            $manager->flush();

            // return $this->json(['message' => 'Enlevé de vos favoris'], 200);
            // retourner à la page d'accueil
            return $this->redirectToRoute('accueil');
        } 

        $ad->addLike($user);
        $manager->flush();

        // return $this->json(['message' => 'Ajouté à vos favoris'], 200);
        return $this->redirectToRoute('accueil');
    }
}