<?php

namespace App\Controller\Account;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController{
    #[Route('/compte', name: 'app_account')]
    public function index(CommentRepository $commentRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connectéRécupérer les commentaires de l'utilisateur
        $comments = $commentRepository->findBy(
            ['author' => $user], // Filtrer par utilisateur connecté
            ['createdAt' => 'DESC'], // Trier par date décroissante
            5 // Limiter à 5 commentaires
        );

        return $this->render('account/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/compte/commentaires', name: 'app_account_all_comments')]
    public function allComments(CommentRepository $commentRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté
        $comments = $commentRepository->findBy(
            ['author' => $user], // Filtrer par utilisateur connecté
            ['createdAt' => 'DESC'] // Trier par date décroissante
        );

        return $this->render('account/all_comments.html.twig', [
            'comments' => $comments,
        ]);
    }
}
