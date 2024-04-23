<?php

namespace App\Controller\security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginFormController extends AbstractController
{
    
     #[Route("/login", name:"app_login")]
     
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // obtenir l'erreur de login si elle existe
        $error = $authenticationUtils->getLastAuthenticationError();
        // dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login_form/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    
    //   #[Route("/logout", name:"app_accueil")]
    
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
