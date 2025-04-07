<?php

namespace App\Controller\Home;

use App\Repository\AboutRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResumeController extends AbstractController
{
    #[Route('/mon-parcours', name: 'app_resume')]
    public function index(AboutRepository $aboutRepository, ProjectRepository $projectRepository): Response
    {
        $about = $aboutRepository->find(1); // En supposant qu'il n'y ait qu'une seule entité About

        if (!$about) {
            // Gérer le cas où l'entité About n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations de mon parcours ne sont pas disponibles.',
            ]);
        }

        $projects = $projectRepository->findAll();

        // Récupérer toutes les compétences, frameworks et APIs
        $skills = [];
        $frameworks = [];
        $apis = [];

        foreach ($projects as $project) {
            foreach ($project->getSkills() as $skill => $value) {
                if (!isset($skills[$skill])) {
                    $skills[$skill] = 0;
                }
                $skills[$skill] += $value;
            }

            foreach ($project->getFrameworks() as $framework => $value) {
                if (!isset($frameworks[$framework])) {
                    $frameworks[$framework] = 0;
                }
                $frameworks[$framework] += $value;
            }

            foreach ($project->getApis() as $api => $value) {
                if (!isset($apis[$api])) {
                    $apis[$api] = 0;
                }
                $apis[$api] += $value;
            }
        }

        // Calculer les pourcentages de maîtrise
        $skillsMastery = $this->calculateMastery($skills);
        $frameworksMastery = $this->calculateMastery($frameworks);
        $apisMastery = $this->calculateMastery($apis);

        return $this->render('home/resume.html.twig', [
            'about' => $about,
            'skills' => $skillsMastery,
            'frameworks' => $frameworksMastery,
            'apis' => $apisMastery,
        ]);
    }
    
    private function calculateMastery(array $items): array
    {
        $mastery = [];

        foreach ($items as $key => $usagePercentage) {
             // Calculer l'augmentation de la maîtrise
            $increase = floor($usagePercentage / 10); // Chaque tranche de 10 % d'utilisation augmente la maîtrise de 1 %
            $currentMastery = $mastery[$key]['percentage'] ?? 0; // Maîtrise actuelle (par défaut 0)

            // Ajouter l'augmentation à la maîtrise actuelle
            $newMastery = min($currentMastery + $increase, 100); // Limiter à 100 %
    
            // Déterminer le niveau de maîtrise
            $level = 'Débutant';
            if ($newMastery > 25 && $newMastery <= 50) {
                $level = 'Intermédiaire';
            } elseif ($newMastery > 50 && $newMastery <= 75) {
                $level = 'Avancé';
            } elseif ($newMastery > 75) {
                $level = 'Expert';
            }
    
            // Ajouter le pourcentage et le niveau au tableau
            $mastery[$key] = [
                'percentage' => $newMastery,
                'level' => $level,
            ];
        }

        return $mastery;
    }
}
