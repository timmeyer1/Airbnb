<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\AdsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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



    #[Route('/change-role/{id}', name: 'changeRole', methods: ['GET'])]
    public function changeRole(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {

        $user = $userRepository->find($id);

        
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Ajouter le rôle ROLE_HOTE à l'utilisateur
        $user->setRoles(['ROLE_HOTE']);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Rediriger vers une page appropriée
        return $this->redirectToRoute('accueil');
    }
}
