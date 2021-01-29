<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $weight = $user->getWeight();
        $height = $user->getHeight();


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIndexWeight($weight / ($height * $height));
            $index_weight = $user->getIndexWeight();
            $weight_1 = '2 degree - lack of weight';
            $weight_2 = '1 degree - lack of weight';
            $weight_3 = 'normal weight';
            $weight_4 = 'excess weight';
            $weight_5 = '1st degree obesity';
            $weight_6 = '2st degree obesity';
            $weight_7 = '3st degree obesity';

            if ($index_weight < 18.0) {
                $user->setResult($weight_1);
            } else if ($index_weight < 20.0) {
                $user->setResult($weight_2);
            } else if ($index_weight < 25.0) {
                $user->setResult($weight_3);
            } else if ($index_weight < 27.0) {
                $user->setResult($weight_4);
            } else if ($index_weight < 30.0) {
                $user->setResult($weight_5);
            } else if ($index_weight < 35.0) {
                $user->setResult($weight_6);
            } else {
                $user->setResult($weight_7);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
