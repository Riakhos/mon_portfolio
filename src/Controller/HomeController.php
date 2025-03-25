<?php

namespace App\Controller;

use App\Repository\PricingPlanRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, PricingPlanRepository $pricingPlanRepository): Response
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

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'pricingPlans' => $pricingPlans,
        ]);
    }
}
