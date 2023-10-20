<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchController extends AbstractController
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
    #[Route('/searchmovie', name: 'search_movie')]
    public function getSearchMovie(Request $request): Response
    {
        $searchTerm = $request->query->get('query');
        if (!$searchTerm) {
            return $this->render('confirmation.html.twig', [
                'confirmationMessage' => 'Impossible',
            ]);
        }

        $response = $this->tmbdClient->request(
            'GET',
            '/3/search/movie',
            [
                'query' => ['query' => $searchTerm],
            ]
        );

        $searchResults = json_decode($response->getContent(), true);

        $filteredResults = array_filter($searchResults['results'], function ($result) use ($searchTerm) {
            $title = $result['title'] ?? '';
            $originalTitle = $result['original_title'] ?? '';
            $overview = $result['overview'] ?? '';
            return stripos($title, $searchTerm) !== false || stripos($originalTitle, $searchTerm) !== false || stripos($overview, $searchTerm) !== false;
        });

        return $this->render('searchMovie.html.twig', [
            'searchResults' => ['results' => $filteredResults],  // Utilisez les résultats filtrés
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/searchmedia', name: 'searchMedia')]
    public function searchMedia(Request $request): Response
    {
        $searchTerm = $request->query->get('query');
        $mediaType = $request->query->get('media');

        if (!$searchTerm || !$mediaType) {
            return $this->render('confirmation.html.twig', [
                'confirmationMessage' => 'Impossible',
            ]);
        }

        $endpoint = $mediaType === 'movie' ? '/3/search/movie' : '/3/search/tv';

        $response = $this->tmbdClient->request(
            'GET',
            $endpoint,
            [
                'query' => ['query' => $searchTerm],
            ]
        );

        $searchResults = json_decode($response->getContent(), true);

        $filteredResults = array_filter($searchResults['results'], function ($result) use ($searchTerm) {
            $title = $result['title'] ?? '';
            $originalTitle = $result['original_title'] ?? '';
            $overview = $result['overview'] ?? '';
            return stripos($title, $searchTerm) !== false || stripos($originalTitle, $searchTerm) !== false || stripos($overview, $searchTerm) !== false;
        });

        if ($mediaType === 'movie') {
            return $this->render('searchMovie.html.twig', [
                'searchResults' => ['results' => $filteredResults],
                'searchTerm' => $searchTerm,
                'mediaType' => $mediaType,
            ]);
        } elseif ($mediaType === 'tv') {
            return $this->render('searchSerie.html.twig', [
                'searchResults' => ['results' => $filteredResults],
                'searchTerm' => $searchTerm,
                'mediaType' => $mediaType,
            ]);
        }
        return $this->render('confirmation.html.twig', [
            'confirmationMessage' => 'Type de média non pris en charge',
        ]);
    }
}