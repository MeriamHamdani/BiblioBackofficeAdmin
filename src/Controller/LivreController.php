<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
            'titre' => 'Livres',
            'soustitre' => 'Livres ',
        ]);
    }

    #[Route('/new', name: 'livre_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
            'titre' => 'Livres',
            'soustitre' => 'Livres ',
        ]);
    }

    #[Route('/{id}', name: 'livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'titre' => 'Livres',
            'soustitre' => 'Livres ',
        ]);
    }

    #[Route('/{id}/edit', name: 'livre_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
            'titre' => 'Livres',
            'soustitre' => 'Livres ',
        ]);
    }

    #[Route('/{id}/delete', name: 'livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }
     //2eme meth de supprission pour le lien supprimer
     #[Route('/supprimer/{id}', name: 'livre_delete_2')]
     public function supprimer(Request $request, int $id = -1): Response
     {
         if ($id <= 0) 
             return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
         else 
             {
             $livre = $this-> getDoctrine()->getRepository(Livre::class)->findOneBy(['id'=> $id]); 
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->remove($livre);
             $entityManager->flush();
             return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
             }
 
        
     }
    
}
