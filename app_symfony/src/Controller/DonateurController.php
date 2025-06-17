<?php

namespace App\Controller;

use App\Entity\Donateur;
use App\Form\DonateurForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/donateur')]
#[IsGranted('ROLE_DONATEUR')]
class DonateurController extends AbstractController
{
    #[Route('/register', name: 'app_register_donateur')]
    public function completeProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Si déjà lié à un donateur, on redirige
        if ($user->getDonateur()) {
            return $this->redirectToRoute('app_donateur');
        }

        $donateur = new Donateur();
        $form = $this->createForm(DonateurForm::class, $donateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donateur->setUser($user);
            $entityManager->persist($donateur);
            $entityManager->flush();

            $this->addFlash('success', 'Profil donateur complété avec succès !');
            return $this->redirectToRoute('app_donateur');
        }

        return $this->render('donateur/register.html.twig', [
            'donateurForm' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_donateur')]
    public function accueilDonateur(): Response
    {


        return $this->render('donateur/accueil.html.twig');
    }
}
