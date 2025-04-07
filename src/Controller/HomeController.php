<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Message;
use App\Entity\Project;
use App\Form\CommentType;
use App\Form\MessageType;
use App\Repository\BlogPostRepository;
use App\Repository\PricingPlanRepository;
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
    public function index(ServiceRepository $serviceRepository, PricingPlanRepository $pricingPlanRepository, EntityManagerInterface $em, Request $request, BlogPostRepository $blogPostRepository): Response
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
        $projects = $em->getRepository(Project::class)->findBy([], ['updated' => 'DESC', 'created_at' => 'DESC']);

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

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'pricingPlans' => $pricingPlans,
            'projects' => $projects,
            'frameworks' => $frameworks,
            'messageForm' => $form->createView(),
            'latestBlogPosts' => $latestBlogPosts,
            'commentForms' => $commentForms,
        ]);
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
