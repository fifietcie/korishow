<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Watchlist;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WatchlistViewController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/watchlist', name: 'watchlist')]
    public function index(EntityManagerInterface $em, HttpClientInterface $httpClient): Response
    {
        $userId = $this->getUser()->getUserIdentifier();
        if (!$userId) {
            return $this->redirectToRoute('login');
        }

        $watchlistRepository = $em->getRepository(Watchlist::class);
        $watchlist = $watchlistRepository->findBy(['user_id' => $userId]);

        $animeDetailsList = [];

        foreach ($watchlist as $watchlistItem) {
            $animeId = $watchlistItem->getAnimeId();
            $apiUrl = "http://localhost:3000/anime/gogoanime/info/" . $animeId;

            $response =  $httpClient->request('GET', $apiUrl);

            if ($response->getStatusCode() === 200) {
                $animeDetails = $response->toArray();
                array_push($animeDetailsList, $animeDetails);
            }
        }


        return $this->render('watchlist_view/index.html.twig', [
            'watchlist' => $animeDetailsList,
        ]);
    }
}
