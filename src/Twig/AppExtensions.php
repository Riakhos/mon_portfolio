<?php

namespace App\Twig;

use App\Entity\About;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getGlobals(): array
    {
        return [
            'about' => $this->em->getRepository(About::class)->find(1),
        ];
    }
}