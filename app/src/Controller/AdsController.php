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
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/ads')]
class AdsController extends AbstractController
{
    // #[Route('/', name: 'app_ads_index', methods: ['GET'])]
    // public function index(AdsRepository $adsRepository): Response
    // {
    //     return $this->render('ads/index.html.twig', [
    //         'ads' => $adsRepository->findAll(),
    //     ]);
    // }

    #[Route('/add-ad/{id}', name: 'addAd', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, UserRepository $userRepository)
    {
        $ad = new Ads();
        // récupérer l'id de l'utilisateur
        $ad->setUserId($userRepository->find($id));
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //gestion de l'image uploadée
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                //si une image est uploadée, on récupère son nom d'origine
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                //on genere un nouveau nom unique pour éviter d'ecraser des images de même nom
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    //on déplace l'image uploadée dans le dossier public/images
                    $imageFile->move(
                        //games_images_directory est configuré dans config/services.yaml
                        $this->getParameter('dossier_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors de l\'upload de l\'image');
                }

                //on donne le nouveau nom pour la bdd
                $ad->setImagePath($newFilename);
                $entityManager->persist($ad);
                $entityManager->flush();

                return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('ads/new.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    // #[Route('/show/{id}', name: 'showAd', methods: ['GET'])]
    // public function show(Ads $ad): Response
    // {
    //     return $this->render('ads/show.html.twig', [
    //         'ad' => $ad,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'editAd', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ads $ad, EntityManagerInterface $entityManager): Response
    {
        // on vérifie si l'utilisateur est propriétaire
        if ($this->getUser() !== $ad->getUserId()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'éditer cette annonce.');
        }

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

    #[Route('/{id}', name: 'deleteAd', methods: ['POST', 'GET'])]
    public function delete(Request $request, Ads $ad, EntityManagerInterface $entityManager): Response
    {
        // on vérifie si l'utilisateur est propriétaire
        if ($this->getUser() !== $ad->getUserId()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'éditer cette annonce.');
        }

        if ($this->isCsrfTokenValid('delete' . $ad->getId(), $request->request->get('_token'))) {

            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('myAds', [], Response::HTTP_SEE_OTHER);
    }
}
