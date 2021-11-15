<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuteurController extends AbstractController
{
    #[Route('/auteur', name: 'auteur_index', methods: ['GET'])]
    public function index(AuteurRepository $auteurRepository): Response
    {
        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurRepository->findAll(),
            'titre' => 'Auteurs',
            'soustitre' => 'Auteurs ',
        ]);
    }

    #[Route('/new', name: 'auteur_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form,
            'titre' => 'Auteurs',
            'soustitre' => 'Auteurs ',
        ]);
    }

    #[Route('/{id}', name: 'auteur_show', methods: ['GET'])]
    public function show(Auteur $auteur): Response
    {
        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur,
            'titre' => 'Auteurs',
            'soustitre' => 'Auteurs ',
        ]);
    }

    #[Route('/{id}/edit', name: 'auteur_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Auteur $auteur): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form,
            'titre' => 'Auteurs',
            'soustitre' => 'Auteurs ',
        ]);
    }

    #[Route('/{id}', name: 'auteur_delete', methods: ['POST'])]
    public function delete(Request $request, Auteur $auteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($auteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
    }
    //2eme meth de supprission pour le lien supprimer
    #[Route('/supprimer/{id}', name: 'auteur_delete_2')]
    public function supprimer(Request $request, int $id = -1): Response
    {
        if ($id <= 0) 
            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        else 
            {
            $auteur = $this-> getDoctrine()->getRepository(Auteur::class)->findOneBy(['id'=> $id]); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($auteur);
            $entityManager->flush();
            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
            }

       
    }
}
