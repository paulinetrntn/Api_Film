<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;



#[Route('/movie')]

class MovieController extends AbstractController{

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
    public function getMovies(): Response
    {
        $movies=[];//tableau des films
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/popular?language=fr-FR&page=1'
        );
        $data = json_decode($response->getContent(), true);//contenue du json
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $movieData) {
                // Initialise les propriétés de Movie selon les données JSON
                $releaseDate=new \DateTime($movieData['release_date']);
                $picturePath='https://image.tmdb.org/t/p/original'.$movieData["poster_path"];
                //creer le film à l'aide des informations récupérées
                $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"],$movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
                //Récupére les acteurs du film
                $actors=$this->getActors($movieData["id"]);
                foreach ($actors as $actor){
                    //ajoute les acteurs au film
                    $movie->addActor($actor);
                }
                //rajoute le film à la liste des films
                $movies[] = $movie;
            }
        }
        return $this->render('movie.html.twig', [
            'movies' => $movies
        ]);
        return new Response($response->getContent());
    }
    #[Route('/{id}')]
    public function getCredits(int $id) :Response{
        $actors=[];//tableau des films

        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id
        );

        $movieData = json_decode($response->getContent(), true);//contenue du json
        if (isset($movieData) && is_array($movieData)) {
            $releaseDate = new \DateTime($movieData['release_date']);
            //$picturePath = 'https://image.tmdb.org/t/p/original' . $movieData["belongs_to_collection"]["poster_path"];
            $picturePath = 'https://image.tmdb.org/t/p/original' . ($movieData["poster_path"] ?? '');
            $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"], $movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
            $actors = $this->getActors($movieData["id"]);

            foreach ($actors as $actor) {
                $movie->addActor($actor);
            }
        }
        return $this->render('details.html.twig', [
            'actors' => $actors,
            'movie' => $movie,
        ]);
    }
    public function getActors(int $id){
        $actors=[];//tableau des films
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id.'/credits'
        );
        $data = json_decode($response->getContent(), true);//contenue du json
        if (isset($data['cast']) && is_array($data['cast'])) {
            foreach ($data['cast'] as $actorData) {
                // Initialise les propriétés de Actor selon les données JSON
                $actor = new Actor($actorData["id"], $actorData["gender"],$actorData["name"],$actorData["character"]);
                // $movie->addActor($actor); //A AJOUTER PLUS TARD
                //rajoute l'acteur à la liste des acteurs
                $actors[] = $actor;
            }
        }
        return $actors;
    }
}




/*
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
        $actors = $this->getActors($apiMovie["id"]);
        foreach ($actors as $actor) {
            $movie->addActor($actor);
        }

            return $this->render('movie.html.twig',[
                'movies'=>$movies
            ]);
        //return new Response($response->getContent());
    }
*/