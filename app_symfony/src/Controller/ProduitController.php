<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProduitController extends AbstractController
{
    #[Route('/vendeur/produits', name: 'vendeur_produits', methods: ['GET'])]
    public function manageProduits(EntityManagerInterface $em, Security $security): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $vendeur = $user->getVendeur();

        $produits = $em->getRepository(Produit::class)->findBy(['vendeur' => $vendeur]);

        return $this->render('produit/produits.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[IsGranted('ROLE_VENDEUR')]
    #[Route('/vendeur/produit/ajouter', name: 'app_produit_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $user = $security->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $vendeur = $user->getVendeur();
        if (!$vendeur) {
            throw $this->createAccessDeniedException();
        }

        $produit = new Produit();
        $form = $this->createForm(ProduitForm::class, $produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $produit->setVendeur($vendeur);

            $imageFile = $form->get('image_url')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('produit_images_dir'), $newFilename);
                $produit->setImageUrl($newFilename);
            }

            $quantiteDispo = $form->get('quantite_dispo')->getData();
            $produit->setEstDisponible($quantiteDispo > 0);

            $em->persist($produit);
            $em->flush();

           return $this->redirectToRoute('vendeur_produits');

        }

        return $this->render('produit/produit_form.html.twig', [
            'form' => $form->createView(),
            'produit' => null,
            'isFormEdit' => false,
        ]);
    }

    #[IsGranted('ROLE_VENDEUR')]
    #[Route('/produit/{id}/edit', name: 'vendeur_produit_edit', methods: ['GET', 'POST'])]
    public function edit(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        Security $security
    ): Response {
        $produit = $em->getRepository(Produit::class)->find($id);
        if (!$produit) {
            throw $this->createNotFoundException();
        }

        $user = $security->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }
        $vendeur = $user->getVendeur();

        if ($produit->getVendeur()->getId() !== $vendeur->getId()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ProduitForm::class, $produit, [
            'is_edit' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image_url')->getData();

            if ($imageFile) {
                // Suppression de l'ancienne image si elle existe
                if ($produit->getImageUrl()) {
                    $oldImagePath = $this->getParameter('produit_images_dir') . '/' . $produit->getImageUrl();
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Enregistrement de la nouvelle image
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('produit_images_dir'), $newFilename);
                $produit->setImageUrl($newFilename);
            }

            $quantiteDispo = $form->get('quantite_dispo')->getData();
            $produit->setEstDisponible($quantiteDispo > 0);

            $em->flush();

            return $this->redirectToRoute('vendeur_produits');
        }

        return $this->render('produit/produit_form.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
            'isFormEdit' => true,
        ]);
    }

    #[IsGranted('ROLE_VENDEUR')]
    #[Route('/vendeur/produit/{id}/delete', name: 'vendeur_produit_delete', methods: ['POST'])]
    public function delete(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        Security $security
    ): Response {
        $produit = $em->getRepository(Produit::class)->find($id);
        if (!$produit) {
            throw $this->createNotFoundException();
        }

        $user = $security->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }
        $vendeur = $user->getVendeur();

        if ($produit->getVendeur()->getId() !== $vendeur->getId()) {
            throw $this->createAccessDeniedException();
        }

        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete-produit' . $produit->getId(), $submittedToken)) {
            $em->remove($produit);
            $em->flush();
        }

        $produits = $em->getRepository(Produit::class)->findBy(['vendeur' => $vendeur]);

        // ⚠️ Redirection vers la liste des produits
        return $this->redirectToRoute('vendeur_produits');
    }
}
