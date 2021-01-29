<?php

namespace App\Controller;

use App\Entity\Men;
use App\Form\MenType;
use App\Repository\MenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/men")
 */
class MenController extends AbstractController
{
    /**
     * @Route("/", name="men_index", methods={"GET"})
     */
    public function index(MenRepository $menRepository): Response
    {
        return $this->render('men/index.html.twig', [
            'mens' => $menRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="men_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $man = new Men();
        $form = $this->createForm(MenType::class, $man);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($man);
            $entityManager->flush();

            return $this->redirectToRoute('men_index');
        }

        return $this->render('men/new.html.twig', [
            'man' => $man,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="men_show", methods={"GET"})
     */
    public function show(Men $man): Response
    {
        return $this->render('men/show.html.twig', [
            'man' => $man,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="men_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Men $man): Response
    {
        $form = $this->createForm(MenType::class, $man);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('men_index');
        }

        return $this->render('men/edit.html.twig', [
            'man' => $man,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="men_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Men $man): Response
    {
        if ($this->isCsrfTokenValid('delete'.$man->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($man);
            $entityManager->flush();
        }

        return $this->redirectToRoute('men_index');
    }
}
