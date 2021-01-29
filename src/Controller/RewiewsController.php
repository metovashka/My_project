<?php

namespace App\Controller;

use App\Entity\Rewiews;
use App\Form\RewiewsType;
use App\Repository\RewiewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rewiews")
 */
class RewiewsController extends AbstractController
{
    /**
     * @Route("/", name="rewiews_index", methods={"GET"})
     */
    public function index(RewiewsRepository $rewiewsRepository): Response
    {
        return $this->render('rewiews/index.html.twig', [
            'rewiews' => $rewiewsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rewiews_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rewiew = new Rewiews();
        $form = $this->createForm(RewiewsType::class, $rewiew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rewiew);
            $entityManager->flush();

            return $this->redirectToRoute('rewiews_index');
        }

        return $this->render('rewiews/new.html.twig', [
            'rewiew' => $rewiew,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rewiews_show", methods={"GET"})
     */
    public function show(Rewiews $rewiew): Response
    {
        return $this->render('rewiews/show.html.twig', [
            'rewiew' => $rewiew,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rewiews_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rewiews $rewiew): Response
    {
        $form = $this->createForm(RewiewsType::class, $rewiew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rewiews_index');
        }

        return $this->render('rewiews/edit.html.twig', [
            'rewiew' => $rewiew,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rewiews_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rewiews $rewiew): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rewiew->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rewiew);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rewiews_index');
    }
}
