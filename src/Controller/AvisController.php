<?php

namespace App\Controller;


use App\Entity\Avis;
use App\Form\AvisFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;


class AvisController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/addavis', name: 'ajouter_avis')]
    public function ajouterAvis(Request $request): Response
    {
        $avis = new Avis();
        $serieId = $request->get('id');
        $avis->setDate(new \DateTime());

        $form = $this->createForm(AvisFormType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($avis);
            $this->entityManager->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');

            return $this->redirectToRoute('serie_details', ['id' => $serieId ]);

        }
        /*
        return $this->render('confirmation.html.twig', [
            'confirmationMessage' => ' Impossible',
        ]);

        return $this->redirectToRoute('serie_details', ['id' => $serieId]);

        return $this->render('ajouter.html.twig', [
            'form' => $form,]);

        */
        return $this->redirectToRoute('serie_details', ['id' => $serieId]);

    }
}