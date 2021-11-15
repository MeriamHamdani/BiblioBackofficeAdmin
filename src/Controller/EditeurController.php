<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Form\EditeurType;
use App\Repository\EditeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/admin/editeur')]
class EditeurController extends AbstractController
{
    #[Route('/editeur', name: 'editeur_index', methods: ['GET'])]
    public function index(EditeurRepository $editeurRepository): Response
    {
        return $this->render('editeur/index.html.twig', [
            'editeurs' => $editeurRepository->findAll(),
            'titre' => 'Editeurs',
            'soustitre' => 'Editeurs ',
        ]);
    }

    #[Route('/new', name: 'editeur_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $editeur = new Editeur();
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editeur);
            $entityManager->flush();

            return $this->redirectToRoute('editeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('editeur/new.html.twig', [
            'editeur' => $editeur,
            'form' => $form,
            'titre' => 'Editeurs',
            'soustitre' => 'Editeurs ',
        ]);
    }

    #[Route('/{id}', name: 'editeur_show', methods: ['GET'])]
    public function show(Editeur $editeur): Response
    {
        return $this->render('editeur/show.html.twig', [
            'editeur' => $editeur,
            'titre' => 'Editeurs',
            'soustitre' => 'Editeurs ',
        ]);
    }

    #[Route('/{id}/edit', name: 'editeur_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Editeur $editeur): Response
    {
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('editeur/edit.html.twig', [
            'editeur' => $editeur,
            'form' => $form,
            'titre' => 'Editeurs',
            'soustitre' => 'Editeurs ',
        ]);
    }

    #[Route('/{id}', name: 'editeur_delete', methods: ['POST'])]
    public function delete(Request $request, Editeur $editeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('editeur_index', [], Response::HTTP_SEE_OTHER);
    }
      //2eme meth de supprission pour le lien supprimer
      #[Route('/supprimer/{id}', name: 'editeur_delete_2')]
      public function supprimer(Request $request, int $id = -1): Response
      {
          if ($id <= 0) 
              return $this->redirectToRoute('editeur_index', [], Response::HTTP_SEE_OTHER);
          else 
              {
              $editeur = $this-> getDoctrine()->getRepository(Editeur::class)->findOneBy(['id'=> $id]); 
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->remove($editeur);
              $entityManager->flush();
              return $this->redirectToRoute('editeur_index', [], Response::HTTP_SEE_OTHER);
              }
  
         
      }
}
