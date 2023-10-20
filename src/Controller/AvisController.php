<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AvisController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/addavisserie/{id}', name: 'ajouter_avis_serie')]
    public function ajouterAvisSerie(int $id, Request $request): Response
    {
        $avis = new Avis();
        $avis->setDate(new \DateTime());
        $avis->setIdSerie($id);

        $form = $this->createForm(AvisFormType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($avis);
            $this->entityManager->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');

            return $this->redirectToRoute('serie_details', ['id' => $id]);
        }

        return $this->render('ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/addavisfilm/{id}', name: 'ajouter_avis_film')]
    public function ajouterAvisFilm(int $id, Request $request): Response
    {
        $avis = new Avis();
        $avis->setDate(new \DateTime());
        $avis->setIdMovie($id);

        $form = $this->createForm(AvisFormType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($avis);
            $this->entityManager->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');

            return $this->redirectToRoute('movie_details', ['id' => $id]);
        }
        return $this->render('ajouter.html.twig', [
            'form' => $form,
        ]);
    }

}