<?php

// src/Controller/AccueilController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]

    public function index(): Response
    {
        // Premier appel cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:3000/anime/gogoanime/top-airing",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $animes = [];
        } else {
            $data = json_decode($response, true);
            $animes = array_slice($data['results'], 0, 7) ?? [];
        }

        // Deuxième appel cURL
        $curl2 = curl_init();
        curl_setopt_array($curl2, [
            CURLOPT_URL => "http://localhost:3000/anime/gogoanime/recent-episodes",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response2 = curl_exec($curl2);
        $err2 = curl_error($curl2);
        curl_close($curl2);

        if ($err2) {
            $recent_updates = [];
        } else {
            $data2 = json_decode($response2, true);
            $recent_updates = array_slice($data2['results'], 0, 12) ?? [];
            foreach ($recent_updates as &$update) {
                $update['title'] = mb_substr($update['title'], 0, 35);
            }
        }

        // Passer les deux tableaux de résultats à la vue
        return $this->render('accueil/accueil.html.twig', [
            'animes' => $animes,
            'recent_updates' => $recent_updates,
        ]);
    }
}
