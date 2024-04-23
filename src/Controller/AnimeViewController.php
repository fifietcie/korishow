<?php

// src/Controller/AnimeViewController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeViewController extends AbstractController
{
    #[Route('/anime/{id}', name: 'anime_view')]

    public function view(string $id): Response
    {
        $curl = curl_init();

        // Construire l'URL de l'API avec l'ID de l'anime
        $apiUrl = "http://localhost:3000/anime/gogoanime/info/".$id ;
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // Gérer l'erreur si la requête cURL échoue
            $animeDetails = [];
        } else {
            // Décoder la réponse JSON en un tableau associatif
            $animeDetails = json_decode($response, true);
        }

        // Passer les détails de l'anime à la vue
        return $this->render('anime_view/index.html.twig', [
            'anime' => $animeDetails,
        ]);
    }
}
