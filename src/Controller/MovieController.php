<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\SerializerInterface;

class MovieController extends AbstractController {

    #[Route('/')]
    public function getMovies(SerializerInterface $serializer): Response
    {
        $client = HttpClient::create();
        $apiUrl = 'https://api.themoviedb.org/3/movie/popular';
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiOTZjOTdmMzUyYzMxYTdhM2QyNjM4OWNlM2Q1ZDBiYyIsInN1YiI6IjY1MGE5ZmNkOTY2MWZjMDFlNmRhMmE3ZSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.6Mw5oUTKiAEuR98piyoxob9_kjoyd_fSGqMTaFGTRGo',
                'accept' => 'application/json',
            ],
        ]);
        //return new Response($response->getContent());


        $moviesData = $response->toArray();
        $movies = [];

        foreach ($moviesData['results'] as $movieData) {
            $movie = $serializer->deserialize(json_encode($movieData), Movie::class, 'json');
            $movies[] = $movie;
        }

        // Vous pouvez maintenant utiliser le tableau $movies qui contient les films récupérés
        // ...

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }
}