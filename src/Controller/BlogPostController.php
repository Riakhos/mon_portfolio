<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogPostController extends AbstractController
{
    #[Route('/blog/post', name: 'app_blog_post')]
    public function index(BlogPostRepository $blogPostRepository, Request $request, EntityManagerInterface $em): Response
    {
        // Récupérer tous les articles triés par date (du plus récent au plus ancien)
        $blogPosts = $blogPostRepository->findBy([], ['updated' => 'DESC', 'created_at' => 'DESC']);

        if (!$blogPosts) {
            // Gérer le cas où l'entité BlogPost n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations du blog ne sont pas disponibles.',
            ]);
        }

        // Récupérer toutes les catégories et frameworks distincts
        $categories = array_unique(array_merge(...array_map(fn($post) => $post->getCategory() ?? [], $blogPosts)));
        $frameworks = array_unique(array_merge(...array_map(fn($post) => $post->getFramework() ?? [], $blogPosts)));

        // Gestion des commentaires
        $commentForms = [];
        foreach ($blogPosts as $blogPost) {

            // Vérifier si l'utilisateur est connecté
            if ($this->getUser()) {
                $comment = new Comment();
                $comment->setBlogPost($blogPost);
                
                $form = $this->createForm(CommentType::class, $comment);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    /** @var \App\Entity\User $user */
                    $user = $this->getUser();
                    $comment->setAuthor($user->getUsername()); // Utiliser le nom d'utilisateur comme auteur

                    // Enregistrer le commentaire en BDD
                    $em->persist($comment);
                    $em->flush();

                    $this->addFlash(
                        'success',
                        'Votre commentaire a été ajouté avec succès.'
                    );
                    return $this->redirectToRoute('app_blog_post');
                }

                $commentForms[$blogPost->getId()] = $form->createView();
            }
        }

        // Si le formulaire est soumis alors :
        return $this->render('blog-post/index.html.twig', [
            'blogPosts' => $blogPosts,
            'categories' => $categories,
            'frameworks' => $frameworks,
            'commentForms' => $commentForms,
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_post_show', requirements: ['id' => '\d+'])]
    public function show(BlogPostRepository $blogPostRepository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $blogPost = $blogPostRepository->findOneById($id);

        if (!$blogPost) {
            // Gérer le cas où l'entité BlogPost n'est pas trouvée
            return $this->render('@Twig/Exception/error.html.twig', [
                'message' => 'Les informations du blog ne sont pas disponibles.',
            ]);
        }

        $commentForm = null;

        // Vérifier si l'utilisateur est connecté
        if ($this->getUser()) {
            $comment = new Comment();
            $comment->setBlogPost($blogPost); // Associer le commentaire à l'article de blog

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var \App\Entity\User $user */
                $user = $this->getUser();
                $comment->setAuthor($user->getUsername()); // Utiliser le nom d'utilisateur comme auteur

                // Enregistrer le commentaire en BDD
                $em->persist($comment);
                $em->flush();

                // Ajouter un message flash et rediriger
                $this->addFlash(
                    'success',
                    'Votre commentaire a été soumis et sera visible après approbation.'
                );
                return $this->redirectToRoute('blog_post_show', ['id' => $id]);
            }

            $commentForm = $form->createView();
        }

        // Si le formulaire est soumis alors :
        return $this->render('blog-post/show.html.twig', [
            'post' => $blogPost,
            'commentForm' => $commentForm,
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
