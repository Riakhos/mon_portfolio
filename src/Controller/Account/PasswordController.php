<?php

namespace App\Controller\Account;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordController extends AbstractController
{
	private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
	
	#[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = $this->getUser();
        
        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $userPasswordHasherInterface 
        ]);

        $form->handleRequest($request);
        
        // Si le formulaire est soumis alors :
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash(
                'success',
                'Votre mot de passe est correctement mis à jour.'
            );
        }
        
        return $this->render('account/password/update.html.twig', [
            'modifyPwd' => $form->createView()
        ]);
    }
}