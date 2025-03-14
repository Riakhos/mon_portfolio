<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ForgotController extends AbstractController{
    #[Route('/mot-de-passe-oublie', name: 'app_password')]
    public function index(): Response
    {
        // 1. Formulaire de demande de réinitialisation de mot de passe
        // 2. Envoi d'un email avec un lien de réinitialisation
        // 3. Traitement du lien de réinitialisation
        // 4. Formulaire de réinitialisation de mot de passe

        return $this->render('account/password/forgot.html.twig', [
            'controller_name' => 'Account/ForgotController',
        ]);
    }
}
