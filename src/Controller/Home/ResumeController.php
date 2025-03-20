<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResumeController extends AbstractController
{
    #[Route('/resumer', name: 'app_resume')]
    public function index(): Response
    {
        return $this->render('home/resume.html.twig');
    }
}
