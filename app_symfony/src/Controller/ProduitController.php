<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ProduitForm;
use App\Form\CategorieForm;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;

final class ProduitController extends AbstractController
{
    #[IsGranted('ROLE_VENDEUR')]
    #[Route('/vendeur/produit/ajouter', name: 'app_produit_new')]
    public function new(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $user = $security->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur non valide.');
        }

        $vendeur = $user->getVendeur();
        if (!$vendeur) {
            throw $this->createAccessDeniedException('Accès refusé : vous n\'êtes pas un vendeur.');
        }

        // Formulaire produit
        $produit = new Produit();
        $formBuilder = $this->createFormBuilder($produit);
        ProduitForm::build($formBuilder);
        $formProduit = $formBuilder->getForm();

        // Formulaire catégorie
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieForm::class, $categorie);

        // Traitement formulaire catégorie
        $formCategorie->handleRequest($request);
        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès.');

            return $this->redirectToRoute('app_produit_new');
        }

        // Traitement formulaire produit
        $formProduit->handleRequest($request);
        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            $produit->setVendeur($vendeur);

            $imageFile = $formProduit->get('image_url')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('produit_images_dir'), $newFilename);
                $produit->setImageUrl($newFilename);
            }

            $quantiteDispo = $formProduit->get('quantite_dispo')->getData();
            $produit->setEstDisponible($quantiteDispo > 0);

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('app_produit_new');
        }

        return $this->render('produit/ajouter_produit.html.twig', [
            'form' => $formProduit->createView(),
            'categorieForm' => $formCategorie->createView(),
        ]);
    }
}
