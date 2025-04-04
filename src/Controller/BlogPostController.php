<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogPostController extends AbstractController
{
    #[Route('/blog/post', name: 'app_blog_post')]
    public function index(BlogPostRepository $blogPostRepository): Response
    {
        // Récupérer tous les articles triés par date (du plus récent au plus ancien)
        $blogPosts = $blogPostRepository->findBy([], ['updated' => 'DESC', 'created_at' => 'DESC']);

        // Récupérer toutes les catégories et frameworks distincts
        $categories = array_unique(array_merge(...array_map(fn($post) => $post->getCategory() ?? [], $blogPosts)));
        $frameworks = array_unique(array_merge(...array_map(fn($post) => $post->getFramework() ?? [], $blogPosts)));

        return $this->render('blog-post/index.html.twig', [
            'blogPosts' => $blogPosts,
            'categories' => $categories,
            'frameworks' => $frameworks,
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_post_show', requirements: ['id' => '\d+'])]
    public function show(BlogPostRepository $blogPostRepository, $id): Response
    {
        $blogPost = $blogPostRepository->findOneById($id);

        if (!$blogPost) {
            // Gérer le cas où l'entité BlogPost n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations du blog ne sont pas disponibles.',
            ]);
        }

        return $this->render('blog-post/show.html.twig', [
            'post' => $blogPost,
        ]);
    }

    #[Route('/blog/{id}/like', name: 'blog_post_like', methods: ['POST'])]
    public function like(BlogPostRepository $blogPostRepository, EntityManagerInterface $em, $id): JsonResponse
    {
        $blogPost = $blogPostRepository->findOneById($id);

        if (!$blogPost) {
            // Gérer le cas où l'entité BlogPost n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations du blog ne sont pas disponibles.',
            ]);
        }

        // Incrémenter le nombre de likes
        $blogPost->incrementLikes();
        $em->persist($blogPost);
        $em->flush();
        // Renvoyer la réponse JSON avec le nombre de likes mis à jour
        return new JsonResponse(['likes' => $blogPost->getLikes()]);
    }
}
