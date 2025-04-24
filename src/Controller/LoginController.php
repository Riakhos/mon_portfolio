<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Google\Client;

class LoginController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'google_client_id' => $_ENV['GOOGLE_CLIENT_ID'],
        ]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/api/connexion', name: 'api_login', methods: ['POST'])]
    public function apiLogin(): void
    {
        // Cette méthode peut rester vide, Symfony gère automatiquement l'authentification JSON.
        throw new \LogicException('Cette méthode est gérée par le système de sécurité de Symfony.');
    }

    #[Route(path: '/api/deconnexion', name: 'api_logout', methods: ['POST'])]
    public function apiLogout(): void
    {
        // Cette méthode peut rester vide, Symfony gère automatiquement la déconnexion JSON.
        throw new \LogicException('Cette méthode est gérée par le système de sécurité de Symfony.');
    }

    #[Route(path: '/google/auth', name: 'app_google_auth', methods: ['POST'])]
    public function googleAuth(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $token = $data['token'] ?? null;

        if (!$token) {
            return new JsonResponse(['error' => 'Token manquant'], 400);
        }

        try {
            // Valider le jeton avec Google
            $client = new Client(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);
            $payload = $client->verifyIdToken($token);

            if (!$payload) {
                return new JsonResponse(['error' => 'Jeton Google invalide.'], 400);
            }

            // Récupérer les informations de l'utilisateur
            $email = $payload['email'];

            // Vérifier si l'utilisateur existe déjà
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                // Rediriger vers la route d'inscription
                return new JsonResponse([
                    'redirect' => $this->generateUrl('app_register'),
                    'message' => 'Utilisateur non trouvé. Veuillez vous inscrire.'
                ], 302);
            }

            // Connecter l'utilisateur
            $this->container->get('security.token_storage')->setToken(
                new PostAuthenticationToken($user, 'main', $user->getRoles())
            );

            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}