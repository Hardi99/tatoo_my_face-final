<?php

namespace App\Controller;

use App\Repository\SalonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(SalonRepository $repository): Response
    {
        $salons = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
        'salons' => $salons]);
    }
}
