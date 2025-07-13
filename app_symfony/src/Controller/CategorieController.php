<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\CategorieForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategorieController extends AbstractController
{
    #[IsGranted('ROLE_VENDEUR')]
    #[Route('/vendeur/categorie', name: 'app_categorie_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $user = $security->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur non valide.');
        }

        $vendeur = $user->getVendeur();
        if (!$vendeur) {
            throw $this->createAccessDeniedException('Accès refusé : vous n\'êtes pas un vendeur.');
        }

        $categorie = new Categorie();
        $form = $this->createForm(CategorieForm::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès.');

            return $this->redirectToRoute('app_categorie_index');
        }

        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/ajouter_categorie.html.twig', [
            'categorieForm' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    #[IsGranted('ROLE_VENDEUR')]
    #[Route('/vendeur/categorie/supprimer/{id}', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Categorie $categorie, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-categorie' . $categorie->getId(), $request->request->get('_token'))) {
            $em->remove($categorie);
            $em->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_categorie_index');
    }
}
