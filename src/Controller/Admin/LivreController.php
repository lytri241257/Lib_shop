<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="admin_livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('admin/livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_livre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('admin_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('admin/livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
