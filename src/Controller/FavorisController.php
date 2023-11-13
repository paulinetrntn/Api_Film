<?php

namespace App\Controller;

use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/fav')]
class FavorisController extends AbstractController{

    public function __construct( private  HttpClientInterface $tmbdClient){
    }

    #[Route('/all','all')]
    public function getAllFavoris(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        //$favoris =$entityManager->getRepository(Favorite::class)->findBy(['user' => $user]);


        $favorisRepository = $entityManager->getRepository(Favorite::class);
        $favoris = $favorisRepository->findAll();

        return $this->render('favoris.html.twig',[
            'favoris' => $favoris,
            'confirmationMessage' => 'test',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/movie/{id}', name: 'add_movie_to_favorites')]
    public function addMovieToFavorites(int $id, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $existingFavorite = $entityManager->getRepository(Favorite::class)->findOneBy(['idMovie' => $id]);

        if ($existingFavorite) {
            return $this->render('confirmation.html.twig', [
                'confirmationMessage' => 'Le film avec l\'ID ' . $id . ' est déjà dans vos favoris !',
            ]);
        }

        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/' . $id
        );

        $data = json_decode($response->getContent(), true);

        if (isset($data['title'])) {
            $title = $data['title'];

            $favorite = new Favorite();
            $favorite->setUser($user)
                ->setIdMovie($id)
                ->setTitle($title);

            $entityManager->persist($favorite);
            $entityManager->flush();

            return $this->render('confirmation.html.twig', [
                'confirmationMessage' => 'Le film "' . $title . '" avec l\'ID ' . $id . ' a été ajouté aux favoris avec succès !',
            ]);
        }

        return $this->render('confirmation.html.twig', [
            'confirmationMessage' => 'Le film avec l\'ID ' . $id . ' n\'a pas été trouvé !',
        ]);
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/serie/{id}', name: 'add_serie_to_favorites')]
    public function addSerieToFavorites(int $id, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $existingFavorite = $entityManager->getRepository(Favorite::class)->findOneBy(['idSerie' => $id]);

        if ($existingFavorite) {
            return $this->render('confirmation.html.twig', [
                'confirmationMessage' => 'La série avec l\'ID ' . $id . ' est déjà dans vos favoris !',
            ]);
        }
        else{
            $response = $this->tmbdClient->request(
                'GET',
                '/3/tv/' . $id
            );

            $data = json_decode($response->getContent(), true);

            if (isset($data['name'])) {
                $title = $data['name'];

                $favorite = new Favorite();
                $favorite->setIdSerie($id);
                $favorite->setUser($user);
                $favorite->setTitle($title);

                $entityManager->persist($favorite);
                $entityManager->flush();

                return $this->render('confirmation.html.twig', [
                    'confirmationMessage' => 'La série "' . $title . '" avec l\'ID ' . $id . ' a été ajoutée aux favoris avec succès !',
                ]);
            }
        }
        return $this->render('confirmation.html.twig', [
            'confirmationMessage' => 'La série avec l\'ID ' . $id . ' n\'a pas été trouvée !',
        ]);
    }


    #[Route('/fav', name: 'favors')]
    public function Favorites(): Response
    {
        return $this->render('favoris.html.twig');
    }

}