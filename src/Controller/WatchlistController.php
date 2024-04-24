<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Watchlist;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;


class WatchlistController extends AbstractController
{
    #[Route('/watchlist/add', name: 'watchlist_add', methods: ['POST'])]

public function addAnimeToWatchlist(Request $request, TokenStorageInterface $tokenStorage, HttpClientInterface $httpClient, EntityManagerInterface $entityManager): Response
{
    // ... autres parties du code ...

    $animeId = $request->request->get('id');
    $response = $httpClient->request('GET', "https://api.consumet.org/anime/gogoanime/info/".$id);

    if ($response->getStatusCode() !== 200) {
        return $this->json(['error' => 'Anime non trouvé'], Response::HTTP_NOT_FOUND);
    }

    $animeData = $response->toArray();

    // Vérifiez si l'anime est déjà dans la watchlist de l'utilisateur pour éviter les doublons
    $existingEntry = $entityManager->getRepository(Watchlist::class)->findOneBy([
        'user' => $user_id,
        'animeId' => $animeId,
    ]);

    if ($existingEntry) {
        return $this->json(['error' => 'Anime déjà dans la watchlist'], Response::HTTP_CONFLICT);
    }

    $watchlistEntry = new Watchlist();
    $watchlistEntry->setUser($user_id );
    $watchlistEntry->setAnimeId($animeId);
    // Vous pouvez ajouter des champs supplémentaires ici, par exemple pour stocker le titre et l'image si nécessaire

    $entityManager->persist($watchlistEntry);
    $entityManager->flush();

    return $this->json(['success' => 'Anime ajouté à la watchlist'], Response::HTTP_CREATED);
}
}