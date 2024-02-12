<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrandController extends AbstractController
{
    #[Route('/brand', name: 'app_brand')]
    public function index(): Response
    {
        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
        ]);
    }

    #[Route('/brand/create', name: 'app_brand_create')]
    #[Route('/brand/edit/{brand}', name: 'app_brand_edit')]
    public function create(
        EntityManagerInterface $em,
        Request $request,
        Brand $brand = null
    ): Response {
        if (!$brand) {
            $brand = new Brand();
        }

        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($brand);
            $em->flush();
        }

        return $this->render('brand/create.html.twig', [
            'varForm' => $form->createView(),
        ]);
    }
}
