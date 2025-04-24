<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterUserType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user= new User();
        
        $form = $this->createForm(RegisterUserType::class, $user);

        $form->handleRequest($request);
        
        // Si le formulaire est soumis alors :
        if ($form->isSubmitted() && $form->isValid()) {
            // Tu définis la date de création de l'utilisateur
            $user->setCreatedAt(new DateTimeImmutable());

            // Tu enregistres les datas en BDD
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                'Votre compte est correctement créé, veuillez-vous connecter.'
            );
            
            // Envoie d'un email de confirmation d'inscription
            $mail = new Mail();
            $vars = [
                'username' => $user->getUsername()
            ];
            $mail->send($user->getEmail(), $user->getUsername(), 'Bienvenue sur Le blog de Richard Bonnegent', 'welcome.html', $vars);
            
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView(),
            'google_client_id' => $_ENV['GOOGLE_CLIENT_ID'],
        ]);
    }

    #[Route('/google/inscription', name: 'app_google_register', methods: ['POST'])]
    public function googleRegister(
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
            $client = new \Google\Client(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);
            $payload = $client->verifyIdToken($token);

            if (!$payload) {
                return new JsonResponse(['error' => 'Jeton Google invalide.'], 400);
            }

            // Récupérer les informations de l'utilisateur
            $email = $payload['email'];

            // Vérifier si l'utilisateur existe déjà
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                return new JsonResponse([
                    'redirect' => $this->generateUrl('app_login'),
                    'message' => 'Un compte existe déjà avec cet e-mail. Veuillez vous connecter.'
                ], 302);
            }

            // Créer un nouvel utilisateur
            $user = new User();
            $user->setEmail($email);
            $user->setPassword(''); // Pas de mot de passe pour les connexions via Google
            $user->setCreatedAt(new \DateTimeImmutable());

            $em->persist($user);
            $em->flush();

            // Retourner une réponse de succès
            return new JsonResponse([
                'redirect' => $this->generateUrl('app_login'),
                'message' => 'Votre compte a été créé avec succès. Veuillez vous connecter.'
            ], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}