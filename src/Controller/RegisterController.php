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
            'registerForm' => $form->createView()
        ]);
    }
}