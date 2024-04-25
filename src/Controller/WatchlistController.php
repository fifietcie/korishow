<?php

namespace App\Controller;

use App\Entity\Watchlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class WatchlistController extends AbstractController
{
    #[Route('/anime/add-to-watchlist/{id}', name: 'anime_add_to_watchlist')]
    public function addToWatchlist(string $id, EntityManagerInterface $em): Response
    {
        $userId = $this->getUser()->getUserIdentifier();
        if (!$userId) {
            return $this->redirectToRoute('login');
        }

        $watchlist = new Watchlist();
        $watchlist->setUserId($userId);
        $watchlist->setAnimeId($id);

        $em->persist($watchlist);
        $em->flush();

        return $this->redirectToRoute('anime_view', ['id' => $id]);
    }
}