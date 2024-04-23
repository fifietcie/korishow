<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimeSearchController extends AbstractController
{
    /**
     * @Route("/search-page", name="search_page")
     */
    public function view(): Response
    {
        return $this->render('anime_search/anime-search.html.twig');
    }
}
