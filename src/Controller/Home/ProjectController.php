<?php

namespace App\Controller\Home;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/projet', name: 'app_project')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer tous les projets et les trier par date décroissante
        $projects = $em->getRepository(Project::class)->findBy([], ['updated' => 'DESC', 'created_at' => 'DESC']);

        $totalSkills = array_sum(array_map(function ($project) {
            return array_sum(array_values($project->getSkills()));
        }, $projects));

        $totalFrameworks = array_sum(array_map(function ($project) {
            return array_sum(array_values($project->getFrameworks()));
        }, $projects));

        $totalApis = array_sum(array_map(function ($project) {
            return array_sum(array_values($project->getApis()));
        }, $projects));

        // Récupérer tous les frameworks uniques à partir des projets
        $frameworks = [];
        foreach ($projects as $project) {
            $frameworks = array_merge($frameworks, array_keys($project->getFrameworks()));
        }
        $frameworks = array_unique($frameworks); // Supprimer les doublons

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'totalSkills' => $totalSkills,
            'totalFrameworks' => $totalFrameworks,
            'totalApis' => $totalApis,
            'frameworks' => $frameworks,
        ]);
    }

    #[Route('/projet/{id}', name: 'app_project_show', requirements: ['id' => '\d+'])]
    public function show(Project $project): Response
    {
        // Rendre la vue pour afficher les détails du projet
        return $this->render('project/project_show.html.twig', [
            'project' => $project,
        ]);
    }
}
