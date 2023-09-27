<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MovieController extends AbstractController {

    public function __construct( private  HttpClientInterface $tmbdClient){
    }

    #[Route('/all')]
    public function getAllMovies(): Response
    {
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/popular?language=fr-FR&page=1'
        );

        return new Response($response->getContent());
    }


    #[Route('/popular')]
    public function getPopularMovies(): Response
    {
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/popular?language=fr-FR&page=1'
        );

            $apiMovies = $response->toArray()['results'];
            $movies = [];

            foreach ($apiMovies as $apiMovie) {
                $movie = new Movie();
                $movie->setTitle($apiMovie['title']);
                $movie->setLanguage($apiMovie['original_language']);
                $movie->setImage('https://image.tmdb.org/t/p/original'.$apiMovie['poster_path']);
                $movie->setReleaseDate(new \DateTime($apiMovie['release_date']));
                $movie->setSynopsis($apiMovie['overview']);
                $movie->setIsAdult($apiMovie['adult']);
                $movie->setNote($apiMovie['vote_average']);
                $movies[] = $movie;
            }

            return $this->render('movie.html.twig',[
                'movies'=>$movies
            ]);

        //return new Response($response->getContent());

    }

    #[Route('/movie/{id}')]
    public function getMoviesById(int $id): Response
    {
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id.'/credits?language=en-FR'
        );
        $apiMovies = $response->toArray()['cast'];
        $actors = [];

        foreach ($apiMovies as $apiMovie) {
            $actor = new Actor();
            $actor->setId($apiMovie['id']);
            $actor->setLastname($apiMovie['original_name']);
            $actor->setGender($apiMovie['gender']);
            $actor->setBiography($apiMovie['known_for_department']);

            $actors[] = $actor;
        }
        return $this->render('actor.html.twig',[
            'actors'=>$actors
        ]);

        //return new Response($response->getContent());
    }
}