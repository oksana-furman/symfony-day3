<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Form\DishesType;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    #[Route('/', name: 'app_food')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $dishes = $doctrine->getRepository(Dishes::class)->findAll();
        // dd($dishes);
        return $this->render('food/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }

    #[Route('/details/{id}', name: 'app_food_details')]
    public function details(ManagerRegistry $doctrine, $id): Response
    {
        $dish = $doctrine->getRepository(Dishes::class)->find($id);
        $status = $dish->getFkStatus();
        return $this->render('food/details.html.twig', [
            'dish' => $dish,
            'status' => $status,
        ]);
    }
    
    #[Route('/create', name: 'app_food_create')]
    public function create(ManagerRegistry $doctrine, Request $request, FileUploader $fileUploader): Response
    {
        $dish = new Dishes();
        $form = $this->createForm(DishesType::class, $dish);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dish = $form->getData();

            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader->upload($picture);
                $dish->setPicture($pictureName);
            }

            $em = $doctrine->getManager();
            $em->persist($dish);
            $em->flush();

            return $this->redirectToRoute('app_food');
        }

        return $this->render('food/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_food_edit')]
    public function edit(ManagerRegistry $doctrine, Request $request, $id, FileUploader $fileUploader): Response
    {
        $dish = $doctrine->getRepository(Dishes::class)->find($id);
        $form = $this->createForm(DishesType::class, $dish);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dish = $form->getData();

            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader->upload($picture);
                $dish->setPicture($pictureName);
            }

            $em = $doctrine->getManager();
            $em->persist($dish);
            $em->flush();

            return $this->redirectToRoute('app_food');
        }
        return $this->render('food/edit.html.twig', [
            'form' => $form,  
        ]);
    }

    #[Route('/delete/{id}', name: 'app_food_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $dish = $doctrine->getRepository(Dishes::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($dish);
        $em->flush();

        return $this->redirectToRoute('app_food');
    }
}
