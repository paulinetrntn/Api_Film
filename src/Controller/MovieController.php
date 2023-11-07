<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Movie;
use App\Entity\Actor;
use App\Entity\Favorite;
use App\Entity\Opinion;
use App\Form\AvisFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/movie')]
class MovieController extends AbstractController{

    public function __construct( private  HttpClientInterface $tmbdClient){
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/all')]
    public function getAllMovies(): Response
    {
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/popular?language=fr-FR&page=1'
        );
        return new Response($response->getContent());
    }
    /**
     * @Route("/",name="redirectRoot")
     */
    public function RedirectRoot(){
        return $this->redirectToRoute('popularFilm');
    }

    #[Route('/popular','popularFilm')]
    public function getMovies(Request $request): Response
    {
        $movies=[];//tableau des films
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/popular?language=fr-FR&page=1'
        );

        if ($request->query->has('q')) {
            $query = $request->query->get('q');
            $movies = $this->searchMovies($query);
        } else {
            $data = json_decode($response->getContent(), true);
            if (isset($data['results']) && is_array($data['results'])) {
                foreach ($data['results'] as $movieData) {
                    $releaseDate = new \DateTime($movieData['release_date']);
                    $picturePath = 'https://image.tmdb.org/t/p/original' . $movieData["poster_path"];
                    $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"], $movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
                    $actors = $this->getActors($movieData["id"]);
                    foreach ($actors as $actor) {
                        $movie->addActor($actor);
                    }
                    $movies[] = $movie;
                }
            }
        }
        return $this->render('movie.html.twig', [
            'movies' => $movies
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    #[Route('/{id}', name: 'movie_details')]
    public function getCredits(int $id,EntityManagerInterface $entityManager) :Response
    {
        $actors=[];
        $opinions=[];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id
        );
        $movieData = json_decode($response->getContent(), true);
        if (isset($movieData) && is_array($movieData)) {
            $releaseDate = new \DateTime($movieData['release_date']);
            $picturePath = 'https://image.tmdb.org/t/p/original' . ($movieData["poster_path"] ?? '');
            $movie = new Movie(
                (int)$movieData["id"],
                $movieData["title"],
                $picturePath,
                $movieData["video"],
                $movieData["overview"],
                $movieData["original_language"],
                $movieData["adult"],
                $releaseDate,
                $movieData["vote_average"]);
            $actors = $this->getActors($movieData["id"]);
            $opinions = $this->getAvis($movieData["id"]);

            foreach ($actors as $actor) {
                $movie->addActor($actor);
            }
            $form = $this->createForm(AvisFormType::class);
            $avisRepository = $entityManager->getRepository(Avis::class);
            $avis = $avisRepository->findBy(['idMovie' => $id]);
        }
        return $this->render('detailsMovie.html.twig', [
            'actors' => $actors,
            'movie' => $movie,
            'opinions' => $opinions,
            'movieId' => $id,
            'form' => $form->createView(),
            'avis' => $avis,
        ]);
    }
    public function getActors(int $id): array
    {
        $actors=[];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id.'/credits'
        );
        $data = json_decode($response->getContent(), true);
        if (isset($data['cast']) && is_array($data['cast'])) {
            foreach ($data['cast'] as $actorData) {
                $actor = new Actor(
                    $actorData["id"],
                    $actorData["gender"],
                    "https://image.tmdb.org/t/p/original" . $actorData["profile_path"],
                    $actorData["name"]);
                // $movie->addActor($actor); //A AJOUTER PLUS TARD
                //rajoute l'acteur à la liste des acteurs
                $actors[] = $actor;
            }
        }
        return $actors;
    }

    //dans Movies/reviews
    public function getAvis(int $id): array
    {
        $opinions=[];
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id.'/reviews'
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
