<?php

namespace App\Twig;

use App\Entity\About;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFilters(): array
	{
		return [
			new TwigFilter('price', [$this, 'formatPrice']),
        ];
	}
	
	public function formatPrice($number)
	{
		return number_format($number, '2', ','). ' €';
	}

    public function getGlobals(): array
    {
        // Récupérer la clé API depuis les variables d'environnement
        $googleMapsApiKey = $_ENV['GOOGLE_MAPS_API_KEY'];

        return [
            'about' => $this->em->getRepository(About::class)->find(1),
            'google_maps_api_key' => $googleMapsApiKey,
        ];
    }
}