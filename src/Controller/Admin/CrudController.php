<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{
    /**
     * @Route("/admin", name="crud.index")
     */
    public function index(): Response
    {
        return $this->render('admin/crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }
}
