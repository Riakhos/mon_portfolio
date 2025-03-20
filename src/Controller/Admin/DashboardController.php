<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\BlogPost;
use App\Entity\Contact;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em= $em;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. Vous pouvez faire en sorte que votre tableau de bord redirige vers une page commune de votre backend
        //
        // 1.1) Si vous avez activé la fonctionnalité « pretty URLs » :
        // return $this->redirectToRoute('admin_user_index') ;
        //
        // 1.2) Même exemple mais en utilisant les « ugly URLs » qui étaient utilisées dans les versions précédentes d'EasyAdmin :
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class) ;
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl()) ;

        // Option 2. Vous pouvez faire en sorte que votre tableau de bord redirige vers différentes pages en fonction de l'utilisateur
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        // return $this->redirectToRoute('...') ;
        // }

        // Option 3. Vous pouvez rendre un modèle personnalisé pour afficher un tableau de bord approprié avec des widgets, etc.
        // (astuce : c'est plus facile si votre template s'étend de @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig') ;

        $userCount = $this->em->getRepository(User::class)->count([]);
        $latestPosts = $this->em->getRepository(BlogPost::class)->findBy([], ['created_at' => 'DESC'], 5);
        $latestContacts = $this->em->getRepository(Contact::class)->findBy([], ['sent_at' => 'DESC'], 5);
        $latestProject = $this->em->getRepository(Project::class)->findOneBy([], ['created_at' => 'DESC']);

        return $this->render('admin/dashboard.html.twig', [
            'user_count' => $userCount,
            'latest_posts' => $latestPosts,
            'latest_contacts' => $latestContacts,
            'latest_project' => $latestProject,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<a href="' . $this->generateUrl('app_home') . '" style="text-decoration: none; color: inherit;">Mon Portfolio</a>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        // 📌 Espace Membres
        yield MenuItem::subMenu('Utilisateur', 'fas fa-users')->setSubItems([
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),
            MenuItem::linkToCrud('About', 'fas fa-info', About::class),
        ]);

        // 📌 Blog
        yield MenuItem::subMenu('Blog', 'fas fa-blog')->setSubItems([
            // MenuItem::linkToCrud('Catégories', 'fas fa-tags', Category::class),
            MenuItem::linkToCrud('Posts', 'fas fa-file-alt', BlogPost::class),
            // MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Comment::class),
        ]);

        // 📌 Contact
        yield MenuItem::subMenu('Contact', 'fas fa-address-book')->setSubItems([
            MenuItem::linkToCrud('Contact', 'fas fa-envelope', Contact::class),
        ]);

        // 📌 Projet
        yield MenuItem::subMenu('Projet', 'fas fa-project-diagram')->setSubItems([
            // MenuItem::linkToCrud('Catégories', 'fas fa-tags', Category::class),
            MenuItem::linkToCrud('Projet', 'fas fa-chart-line', Project::class)
        ]);
    }
}
