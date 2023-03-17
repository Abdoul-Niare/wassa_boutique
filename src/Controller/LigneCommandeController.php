<?php

namespace App\Controller;

use App\Entity\LigneCommande;
use App\Form\LigneCommandeType;
use App\Repository\LigneCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ligne/commande')]
class LigneCommandeController extends AbstractController
{
    #[Route('/', name: 'app_ligne_commande_index', methods: ['GET'])]
    public function index(LigneCommandeRepository $ligneCommandeRepository): Response
    {
        return $this->render('ligne_commande/index.html.twig', [
            'ligne_commandes' => $ligneCommandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LigneCommandeRepository $ligneCommandeRepository): Response
    {
        $ligneCommande = new LigneCommande();
        $form = $this->createForm(LigneCommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ligneCommandeRepository->save($ligneCommande, true);

            return $this->redirectToRoute('app_ligne_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ligne_commande/new.html.twig', [
            'ligne_commande' => $ligneCommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_commande_show', methods: ['GET'])]
    public function show(LigneCommande $ligneCommande): Response
    {
        return $this->render('ligne_commande/show.html.twig', [
            'ligne_commande' => $ligneCommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LigneCommande $ligneCommande, LigneCommandeRepository $ligneCommandeRepository): Response
    {
        $form = $this->createForm(LigneCommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ligneCommandeRepository->save($ligneCommande, true);

            return $this->redirectToRoute('app_ligne_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ligne_commande/edit.html.twig', [
            'ligne_commande' => $ligneCommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_commande_delete', methods: ['POST'])]
    public function delete(Request $request, LigneCommande $ligneCommande, LigneCommandeRepository $ligneCommandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneCommande->getId(), $request->request->get('_token'))) {
            $ligneCommandeRepository->remove($ligneCommande, true);
        }

        return $this->redirectToRoute('app_ligne_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
