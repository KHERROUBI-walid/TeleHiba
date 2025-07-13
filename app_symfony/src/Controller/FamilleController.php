<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Form\FamilleForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CommandeFamilleRepository;

#[Route('/famille')]
// #[IsGranted('ROLE_FAMILLE')]
class FamilleController extends AbstractController
{
    #[Route('/register', name: 'app_register_famille')]
    public function completeProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur a le rôle approprié
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Si l'utilisateur a déjà une Famille, rediriger
        if ($user->getFamille()) {
            return $this->redirectToRoute('app_famille');
        }

        $famille = new Famille();
        $form = $this->createForm(FamilleForm::class, $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $famille->setUser($user);
            $entityManager->persist($famille);
            $entityManager->flush();

            $this->addFlash('success', 'Profil famille complété avec succès !');

            return $this->redirectToRoute('app_famille');
        }

        return $this->render('famille/register.html.twig', [
            'familleForm' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_famille')]
    public function index(CommandeFamilleRepository $commandeRepo): Response
    {
                // Vérifier que l'utilisateur a le rôle approprié
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('famille/home.html.twig', [
            'user' => $user,
            'commandes' => $commandeRepo->findBy(['famille' => $user->getFamille()]),
        ]);
    }
    }

