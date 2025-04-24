<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Message;
use App\Entity\Project;
use App\Form\CommentType;
use App\Form\MessageType;
use App\Repository\BlogPostRepository;
use App\Repository\PricingPlanRepository;
use App\Repository\ProjectRepository;
use App\Repository\ServiceRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, PricingPlanRepository $pricingPlanRepository, EntityManagerInterface $em, Request $request, BlogPostRepository $blogPostRepository, ProjectRepository $projectRepository): Response
    {
        $services = $serviceRepository->findAll();

        if (!$services) {
            // Gérer le cas où l'entité Service n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations services ne sont pas disponibles.',
            ]);
        }
        
        $pricingPlans = $pricingPlanRepository->findAll();

        if (!$pricingPlans) {
            // Gérer le cas où l'entité PricingPlan n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations des tarifs ne sont pas disponibles.',
            ]);
        }

        // Récupérer tous les projets triés par date décroissante
        $projects = $em->getRepository(Project::class)->findBy([], ['created_at' => 'DESC']);

        // Récupérer les frameworks uniques
        $frameworks = [];
        foreach ($projects as $project) {
            $frameworks = array_merge($frameworks, array_keys($project->getFrameworks()));
        }
        $frameworks = array_unique($frameworks);

        //Envoyer un message
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        
        // Si le formulaire est soumis alors :
        if ($form->isSubmitted() && $form->isValid()) {
            // Tu définis la date de création de l'utilisateur
            $message->setCreatedAt(new DateTimeImmutable());

            // Tu enregistres les datas en BDD
            $em->persist($message);
            $em->flush();
            $this->addFlash(
                'success',
                'Votre message a été envoyé avec succès.'
            );
        }

        // Récupérer les derniers articles publiés (par exemple, les 5 derniers)
        $latestBlogPosts = $blogPostRepository->findBy([], ['updated' => 'DESC', 'created_at' => 'DESC'], 5);

        if (!$latestBlogPosts) {
            // Gérer le cas où l'entité BlogPost n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les articles de blog ne sont pas disponibles.',
            ]);
        }

        // Gestion des commentaires
        $commentForms = [];
        foreach ($latestBlogPosts as $blogPost) {
            $comment = new Comment();
            $comment->setBlogPost($blogPost);
            
            // Vérifier si l'utilisateur est connecté et définir l'auteur avec getUsername()
            if ($user = $this->getUser()) {
                /** @var \App\Entity\User $user */
                $comment->setAuthor($user->getUsername()); // Utiliser le nom d'utilisateur comme auteur
            }

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Votre commentaire a été ajouté avec succès.');

                return $this->redirectToRoute('app_blog_post');
            }

            $commentForms[$blogPost->getId()] = $form->createView();
        }

        $totalProjects = count($projects);

        // Calculer le nombre total de likes
        $totalLikes = $blogPostRepository->createQueryBuilder('b')
            ->select('SUM(b.likes)')
            ->getQuery()
            ->getSingleScalarResult();

        // Calculer la somme des heures travaillées
        $totalHoursWorked = array_sum(array_map(fn($project) => $project->getHoursWorked(), $projects));

        // Calculer le nombre de cafés bus (1 café toutes les 3 heures)
        $totalCoffees = intdiv($totalHoursWorked, 3);
        
        // $projects = $projectRepository->findAll();

        // Récupérer toutes les compétences, frameworks et APIs
        $skills = [];
        $frameworksUsage = [];
        $apis = [];

        foreach ($projects as $project) {
            foreach ($project->getSkills() as $skill => $value) {
                if (!isset($skills[$skill])) {
                    $skills[$skill] = 0;
                }
                $skills[$skill] += $value;
            }

            foreach ($project->getFrameworks() as $framework => $value) {
                if (!isset($frameworksUsage[$framework])) {
                    $frameworksUsage[$framework] = 0;
                }
                $frameworksUsage[$framework] += $value;
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
        $frameworksMastery = $this->calculateMastery($frameworksUsage);
        $apisMastery = $this->calculateMastery($apis);

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'pricingPlans' => $pricingPlans,
            'projects' => $projects,
            'frameworks' => $frameworks,
            'messageForm' => $form->createView(),
            'latestBlogPosts' => $latestBlogPosts,
            'commentForms' => $commentForms,
            'totalProjects' => $totalProjects,
            'totalLikes' => $totalLikes,
            'totalHoursWorked' => $totalHoursWorked,
            'totalCoffees' => $totalCoffees,
            'skills' => $skillsMastery,
            'frameworksMastery' => $frameworksMastery,
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

    #[Route('/', name: 'app_home_contact')]
    public function contact(EntityManagerInterface $em, Request $request): Response
    {
        //Envoyer un message
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        
        // Si le formulaire est soumis alors :
        if ($form->isSubmitted() && $form->isValid()) {
            // Tu définis la date de création de l'utilisateur
            $message->setCreatedAt(new DateTimeImmutable());

            // Tu enregistres les datas en BDD
            $em->persist($message);
            $em->flush();
            $this->addFlash(
                'success',
                'Votre message a été envoyé avec succès.'
            );
        }

        return $this->render('home/contact.html.twig', [
            'message' => $message,
            'messageForm' => $form->createView(),
        ]);
    }
}
