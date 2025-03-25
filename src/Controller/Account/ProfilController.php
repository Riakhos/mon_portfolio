<?php

namespace App\Controller\Account;

use App\Form\ModifyUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfilController extends AbstractController
{
    #[Route('/compte/profil', name: 'app_account_profil')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ModifyUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageAvatar')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                /** @var \App\Entity\User $user */
                $user = $this->getUser();
                $user->setImageAvatar($newFilename);
            }

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/profil.html.twig', [
            'updateForm' => $form->createView(),
        ]);
    }
}
