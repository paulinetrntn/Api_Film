<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Actor;
use App\Entity\Favorite;
use App\Entity\Opinion;
use Doctrine\ORM\EntityManagerInterface;
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
        $opinions=[];

        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/'.$id
        );

        $movieData = json_decode($response->getContent(), true);//contenue du json
        if (isset($movieData) && is_array($movieData)) {
            $releaseDate = new \DateTime($movieData['release_date']);
            $picturePath = 'https://image.tmdb.org/t/p/original' . ($movieData["poster_path"] ?? '');
            $movie = new Movie($movieData["id"], $movieData["title"], $picturePath, $movieData["video"], $movieData["overview"], $movieData["original_language"], $movieData["adult"], $releaseDate, $movieData["vote_average"]);
            $actors = $this->getActors($movieData["id"]);
            $opinions = $this->getAvis($movieData["id"]);

            foreach ($actors as $actor) {
                $movie->addActor($actor);
            }
        }
        return $this->render('details.html.twig', [
            'actors' => $actors,
            'movie' => $movie,
            'opinions' => $opinions,
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
                $actor = new Actor($actorData["id"], $actorData["gender"], "https://image.tmdb.org/t/p/original" . $actorData["profile_path"],$actorData["name"]);
                // $movie->addActor($actor); //A AJOUTER PLUS TARD
                //rajoute l'acteur à la liste des acteurs
                $actors[] = $actor;
            }
        }
        return $actors;
    }

    //dans Movies/reviews
    public function getAvis(int $id){
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

    #[Route('/fav/{id}', name: 'add_to_favorites')]
    public function addToFavorites(int $id, EntityManagerInterface $entityManager): Response
    {
        $response = $this->tmbdClient->request(
            'GET',
            '/3/movie/' . $id
        );

        $data = json_decode($response->getContent(), true);

        if (isset($data['title'])) {
            $title = $data['title'];

            $favorite = new Favorite();
            $favorite->setIdMovie($id);

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
}
