<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'titre' => 'Catégories',
            'soustitre' => 'Catégories ',
        ]);
    }

    #[Route('/new', name: 'categorie_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'titre' => 'Catégories',
            'soustitre' => 'Catégories '
        ]);
    }

    #[Route('/{id}', name: 'categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'titre' => 'Catégories',
            'soustitre' => 'Catégories '
        ]);
    }

    #[Route('/{id}/edit', name: 'categorie_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'titre' => 'Catégories',
            'soustitre' => 'Catégories '
        ]);
    }
    //meth origine
    #[Route('/{id}/delete', name: 'categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
    }
    //2eme meth de supprission pour le lien supprimer
    #[Route('/supprimer/{id}', name: 'categorie_delete_2')]
    public function supprimer(Request $request, int $id = -1): Response
    {
        if ($id <= 0) 
            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
        else 
            {
            $categorie = $this-> getDoctrine()->getRepository(Categorie::class)->findOneBy(['id'=> $id]); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('categorie_index', [], Response::HTTP_SEE_OTHER);
            }

       
    }

}
