<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Favorite;
use App\Entity\Movie;
use App\Entity\Actor;
use App\Entity\Opinion;
use App\Entity\Serie;
use App\Form\AvisFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Route('/serie')]
class SerieController extends AbstractController
{
    public function __construct(private HttpClientInterface $tmbdClient)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/all')]
    public function getAllSeries(): Response
    {
        $response = $this->tmbdClient->request(
            'GET',
            '/3/tv/popular'
        );
        return new Response($response->getContent());
    }

    #[Route('/popular','popularSerie')]
    public function getSeries(): Response
    {
        $series = [];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/tv/popular'
        );
        $data = json_decode($response->getContent(), true);
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $serieData) {
                $releaseDate = new \DateTime($serieData["first_air_date"]);
                $originCountry = isset($serieData["origin_country"][0]) ? $serieData["origin_country"][0] : null;
                $serie = new Serie(
                    $serieData["id"],
                    $serieData["name"],
                    "https://image.tmdb.org/t/p/original" . $serieData["poster_path"],
                    $serieData["id"],
                    $serieData["original_language"],
                    $serieData["id"],
                    $serieData["vote_count"],
                    $originCountry,
                    $releaseDate,
                    $serieData["overview"],
                    $serieData["adult"]
                );
                $series[] = $serie;
            }
        }
        return $this->render('serie.html.twig', [
            'series' => $series
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    #[Route('/{id}', name: 'serie_details')]
    public function getCredits(int $id , EntityManagerInterface $entityManager): Response
    {
        $actors=[];
        $opinions=[];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/tv/'.$id
        );
        $serieData = json_decode($response->getContent(), true);
        if (isset($serieData) && is_array($serieData)) {
                $releaseDate = new \DateTime($serieData["first_air_date"]);
                $originCountry = $serieData["origin_country"][0] ?? null;
                $serie = new Serie(
                    $serieData["id"],
                    $serieData["name"],
                    "https://image.tmdb.org/t/p/original" . $serieData["poster_path"],
                    $serieData["number_of_seasons"],
                    $serieData["original_language"],
                    $serieData["number_of_episodes"],
                    $serieData["vote_average"],
                    $originCountry,
                    $releaseDate,
                    $serieData["overview"],
                    $serieData["adult"]
                );
                $actors = $this->getActors($serieData["id"]);
                $opinions = $this->getAvis($serieData["id"]);

                foreach ($actors as $actor) {
                    $serie->addActor($actor);
                }
            $form = $this->createForm(AvisFormType::class);
            $avisRepository = $entityManager->getRepository(Avis::class);
            $avis = $avisRepository->findBy(['idSerie' => $id]);
            $form->get('idSerie')->setData($id); // Pré-remplir le champ 'idSerie' avec l'ID de la série
        }
        return $this->render('detailsSerie.html.twig', [
            'actors' => $actors,
            'serie' => $serie,
            'opinions' => $opinions,
            'serieId' => $id,
            'form' => $form->createView(),
            'avis' => $avis,
        ]);
    }

    public function getActors(int $id): array
    {
        $actors=[];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/tv/'.$id.'/credits'
        );
        $data = json_decode($response->getContent(), true);
        if (isset($data['cast']) && is_array($data['cast'])) {
            foreach ($data['cast'] as $actorData) {
                $actor = new Actor(
                    $actorData["id"],
                    $actorData["gender"],
                    "https://image.tmdb.org/t/p/original" . $actorData["profile_path"],
                    $actorData["name"]);
                $actors[] = $actor;
            }
        }
        return $actors;
    }

    public function getAvis(int $id): array
    {
        $opinions=[];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/tv/'.$id.'/reviews'
        );
        $data = json_decode($response->getContent(), true);

        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $opinionData) {
                $authorDetails = $opinionData["author_details"];
                $opinion = new Opinion(
                    (int)$opinionData["id"],
                    $authorDetails["rating"],
                    $opinionData["content"],
                    $authorDetails["username"],
                    "https://image.tmdb.org/t/p/original" .$authorDetails["avatar_path"]
                );
                $opinions[] = $opinion;
            }
        }
        return $opinions;
    }
}
