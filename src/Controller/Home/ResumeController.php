<?php

namespace App\Controller\Home;

use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResumeController extends AbstractController
{
    #[Route('/mon-parcours', name: 'app_resume')]
    public function index(AboutRepository $aboutRepository): Response
    {
        $about = $aboutRepository->find(1); // En supposant qu'il n'y ait qu'une seule entité About

        if (!$about) {
            // Gérer le cas où l'entité About n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations de mon parcours ne sont pas disponibles.',
            ]);
        }

        return $this->render('home/resume.html.twig', [
            'about' => $about,
        ]);
    }
}
