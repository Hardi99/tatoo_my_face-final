<?php

namespace App\Controller;

use App\Entity\TatooStyle;
use App\Form\TatooStyleType;
use App\Repository\TatooStyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tatoo_style")
 */
class TatooStyleController extends AbstractController
{

    /**
     * @var SalonRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(TatooStyleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="tatoo_style.index", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TatooStyleRepository $tatooStyleRepository): Response
    {
        $tatoo_style = $this->repository->findAll();
        return $this->render('admin/tatoo_style/index.html.twig', compact('tatoo_style'));
    }

    /**
     * @Route("/new", name="tatoo_style.new", methods={"GET", "POST"})
     */
    public function new(Request $request, TatooStyleRepository $tatooStyleRepository): Response
    {
        $tatooStyle = new TatooStyle();
        $form = $this->createForm(TatooStyleType::class, $tatooStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tatooStyleRepository->add($tatooStyle);
            return $this->redirectToRoute('tatoo_style.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tatoo_style/new.html.twig', [
            'tatoo_style' => $tatooStyle,
            'form' => $form->createView(),
        ]);
    }
}
