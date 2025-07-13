<?php

namespace App\Controller;

use App\Entity\Donateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/donateur')]
#[IsGranted('ROLE_DONATEUR')]
class DonateurController extends AbstractController
{
    #[Route('/register', name: 'app_register_donateur')]
    public function completeProfile(EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non connecté.');
        }

        // Si déjà lié à un Donateur, on redirige
        if ($user->getDonateur()) {
            return $this->redirectToRoute('app_donateur');
        }

        $donateur = new Donateur();
        $donateur->setUser($user);

        $entityManager->persist($donateur);
        $entityManager->flush();

        $this->addFlash('success', 'Votre profil donateur a bien été créé.');

        return $this->redirectToRoute('app_donateur');
    }

    #[Route('/', name: 'app_donateur')]
    public function accueilDonateur(): Response
    {
        return $this->render('donateur/accueil.html.twig');
    }
}
