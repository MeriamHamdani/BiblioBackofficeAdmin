<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\Categorie;
use App\Entity\Editeur;

//#[Route('/admin/accueil')]
class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(): Response
    {
        $nbAuteurs =count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nbLivres =count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $nbCatégories =count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        $nbEditeurs =count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        return $this->render('accueil/index.html.twig', [
            'titre' => 'Accueil',
            'soustitre' => 'Accueil ',
            'lien' => $this->generateUrl('accueil'),
            'nbAuteurs' => $nbAuteurs,
            'nbLivres'=>$nbLivres,
            'nbCatégories'=>$nbCatégories,
            'nbEditeurs'=>$nbEditeurs,
        ]);
      
    }
}
