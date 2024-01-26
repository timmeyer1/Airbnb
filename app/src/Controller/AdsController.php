<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Form\AdsType;
use App\Repository\AdsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ads')]
class AdsController extends AbstractController
{
    #[Route('/', name: 'app_ads_index', methods: ['GET'])]
    public function index(AdsRepository $adsRepository): Response
    {
        return $this->render('ads/index.html.twig', [
            'ads' => $adsRepository->findAll(),
        ]);
    }

    #[Route('/add-ad/{id}', name: 'addAd', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, UserRepository $userRepository): Response
    {
        $ad = new Ads();
        // récupérer l'id de l'utilisateur
        $ad->setUserId($userRepository->find($id));
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ads/new.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'showAd', methods: ['GET'])]
    // public function show(Ads $ad): Response
    // {
    //     return $this->render('ads/show.html.twig', [
    //         'ad' => $ad,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'editAd', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ads $ad, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ads/edit.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'deleteAd', methods: ['POST'])]
    public function delete(Request $request, Ads $ad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
    }
}
