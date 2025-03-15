<?php

namespace App\Controller\Account;

use App\Classe\Mail;
use App\Form\ForgotPasswordFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ForgotController extends AbstractController{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/mot-de-passe-oublie', name: 'app_password')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        // 1. Formulaire de demande de réinitialisation de mot de passe
        $form = $this->createForm(ForgotPasswordFormType::class);
        $form->handleRequest($request);

        // 2. Envoi d'un email avec un lien de réinitialisation
        if ($form->isSubmitted() && $form->isValid()) {
            // 3. Récupération de l'email
            $email = $form->get('email')->getData();

            $user = $userRepository->findOneByEmail($email);

            // 4. Message de confirmation
            $this->addFlash(
                'success',
                'Si votre adresse email existe, vous recevrez un mail pour réinitialiser votre mot de passe.'
            );

            // 5. Si user existe, on reset le password et on envoie par mail le nouveau mot de passe
            if ($user) {
                // 5. a) Créer un token qu'on va stocker en BDD 
                $token = bin2hex(random_bytes(15));
                $user->setToken($token);

                $date = new DateTime();
                $date->modify('+10 minutes');

                $user->setTokenExpireAt($date);
                
                $this->em->flush();

                // 5. b) Envoi du mail
                $mail = new Mail();
                $vars = [
                    'link' => $this->generateUrl('app_password_update',
                    ['token' => $token],
                    UrlGeneratorInterface::ABSOLUTE_URL)
                ];
                $mail->send(
                    $user->getEmail(),
                    $user->getUserName(),
                    'Réinitialisation de votre mot de passe',
                    'forgotPassword.html',
                    $vars
                );
            }
        }

        return $this->render('account/password/forgot.html.twig', [
            'forgotPasswordForm' => $form->createView()
        ]);
    }

    #[Route('/mot-de-passe/update/{token}', name: 'app_password_update')]
    public function update(Request $request, $token, UserRepository $userRepository): Response
    {
        // 1. Vérification de la présence du token
        if (!$token) {
            return $this->redirectToRoute('app_password');
        }

        // 2. Récupération de l'utilisateur par le token
        $user = $userRepository->findOneByToken($token);
        $now = new DateTime();

        // 3. Vérification de l'existence de l'utilisateur et de l'expiration du token
        if (!$user || $now > $user->getTokenExpireAt()) {
            return $this->redirectToRoute('app_password');
        }

        // 4. Création du formulaire de réinitialisation de mot de passe
        $form = $this->createForm(ResetPasswordFormType::class, $user);
        $form->handleRequest($request);

        // 5. Traitement du formulaire de réinitialisation
        if ($form->isSubmitted() && $form->isValid()) {
            // 6. Réinitialisation du token et de sa date d'expiration
            $user->setToken(null);
            $user->setTokenExpireAt(null);

            // 7. Sauvegarde des modifications
            $this->em->flush();

            // 8. Ajout d'un message de confirmation
            $this->addFlash(
                'success',
                'Votre mot de passe est correctement mis à jour.'
            );

            // 9. Envoi d'un email de confirmation de la modification du mot de passe
            $mail = new Mail();
            $vars = [
                'username' => $user->getUsername()
            ];
            $mail->send($user->getEmail(), $user->getUsername(), 'Mot de passe modifié', 'modifyPassword.html', $vars);

            // 10. Redirection vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // 11. Affichage du formulaire de réinitialisation de mot de passe
        return $this->render('account/password/reset.html.twig', [
            'resetPasswordForm' => $form->createView()
        ]);
    }
}
