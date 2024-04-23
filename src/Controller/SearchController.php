<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{query}", methods={"GET"}, name="search", requirements={"query"=".+"})
     */
    public function search(string $query): Response
    {
        error_log("Received query: " . $query);

        if (empty($query) || strlen($query) < 3) {
            return $this->render('search/no_results.html.twig');
        }

        $url = "http://localhost:3000/anime/gogoanime/" . rawurlencode($query);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            // Log or handle error appropriately
            return $this->render('search/error.html.twig', ['message' => 'Failed to fetch data from API.']);
        }
        curl_close($ch);

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Log or handle error appropriately
            return $this->render('search/error.html.twig', ['message' => 'Invalid JSON response from API.']);
        }

        return $this->render('search/results.html.twig', ['results' => $data['results'] ?? []]);
    }
}
