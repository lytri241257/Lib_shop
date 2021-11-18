<?php

namespace App\Controller;

use App\DTO\SearchCriteria;

use App\Form\SearchCriteriaType;
use App\Repository\AuteurRepository;
use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function indexListe(AuteurRepository $auteurRepository, CategorieRepository $categorieRepository, LivreRepository $livreRepository): Response
    {
        $dernierLivre = $livreRepository->findLast();
        $dernierAuteur = $auteurRepository->findLast();
        $dernierCategorie = $categorieRepository->findLast();
        return $this->render('home/index.html.twig', [
            'livres' => $dernierLivre,
            'auteurs' => $dernierAuteur,
            'categories' => $dernierCategorie,
        ]);
        
    }
    /**
     * @Route("/rechercher", name="rechercher")
     */
    public function rechercher(Request $request, LivreRepository $livreRepository): Response
    {
        $form = $this->createForm(SearchCriteriaType::class);
        $form->handleRequest($request);
        $livre = $livreRepository->findLivresCriteria($form->getData());
        return $this->render('admin/livre/recherche.html.twig', ['form'=> $form->createView(), 'livre' => $livre]);


    }

    /**                  //Wildcard
     * @Route("admin/livre/{id}", name="admin_livre_show")
     */
      public function showLivre($id, LivreRepository $livreRepository)
      {
          // find permet de trouver le livre dans la base de données qui a l'id correspondant
          $livre = $livreRepository->find($id);
          return $this->render('admin/livre/accueil.html.twig', ['livre' => $livre]);
      }

      /**                  //Wildcard
     * @Route("admin/auteur/{id}", name="admin_auteur_show")
     */
    public function showAuteur($id, AuteurRepository $auteurRepository)
    {
        // find permet de trouver l'auteur dans la base de données qui a l'id correspondant
        $auteur = $auteurRepository->find($id);
        return $this->render('admin/auteur/show.html.twig', ['auteur' => $auteur]);
    }


        
}
