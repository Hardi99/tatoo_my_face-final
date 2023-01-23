<?php

namespace App\Controller\Admin;

use App\Entity\TatooStyle;
use App\Form\TatooStyleType;
use App\Repository\TatooStyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/tatoo_style")
 */
class AdminTatooStyleController extends AbstractController
{

    /**
     * @var TatooStyleRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(TatooStyleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.tatoo_style.index", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TatooStyleRepository $tatooStyleRepository)
    {
        $tatoo_style = $this->repository->findAll();
        return $this->render('admin/tatoo_style/index.html.twig', compact('tatoo_style'));
    }

    /**
     * @Route("/create", name="admin.tatoo_style.new", methods={"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $tatooStyle = new TatooStyle();
        $form = $this->createForm(TatooStyleType::class, $tatooStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($tatooStyle);
            $this->em->flush();
            $this->addFlash('success', 'Style ajouté avec succès');
            return $this->redirectToRoute('admin.tatoo_style.index');
        }

        return $this->render('tatoo_style/new.html.twig', [
            'tatoo_style' => $tatooStyle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.tatoo_style.edit", methods={"GET","POST"})
     * @param TatooStyle $tatooStyle
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(TatooStyle $tatooStyle, Request $request)
    {
        $form = $this->createForm(TatooStyleType::class, $tatooStyle);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Style modifié avec succès');
            return $this->redirectToRoute('admin.tatoo_style.index');
        }

        return $this->render('admin/tatoo_style/edit.html.twig', [
            'tatoo_style' => $tatooStyle,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tatoo_style/{id}", name="admin.tatoo_style.delete", methods="DELETE")
     * @param TatooStyle $tatooStyle
     * @return Response
     */
    public function delete(TatooStyle $tatooStyle, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $tatooStyle->getId(), $request->get('_token'))) {
            $this->em->remove($tatooStyle);
            $this->addFlash('success', 'Style supprimé avec succès');
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.tatoo_style.index');
    }
}
