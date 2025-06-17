<?php

namespace App\Controller;

use App\Entity\Vendeur;
use App\Form\VendeurForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/vendeur')]
#[IsGranted('ROLE_VENDEUR')]
class VendeurController extends AbstractController
{
    #[Route('/register', name: 'app_register_vendeur')]
    public function completeProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Si déjà lié à un vendeur, on redirige
        if ($user->getVendeur()) {
            return $this->redirectToRoute('app_vendeur');
        }

        $vendeur = new Vendeur();
        $form = $this->createForm(VendeurForm::class, $vendeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vendeur->setUser($user);
            $entityManager->persist($vendeur);
            $entityManager->flush();

            $this->addFlash('success', 'Profil vendeur complété avec succès !');
            return $this->redirectToRoute('app_vendeur');
        }

        return $this->render('vendeur/register.html.twig', [
            'vendeurForm' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_vendeur')]
    public function accueilVendeur(): Response
    {


        return $this->render('vendeur/accueil.html.twig');
    }
}
