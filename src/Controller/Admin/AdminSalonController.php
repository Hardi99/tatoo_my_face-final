<?php

namespace App\Controller\Admin;

use App\Entity\Salon;
use App\Form\SalonType;
use App\Repository\SalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AdminSalonController extends AbstractController
{

    /**
     * @var SalonRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(SalonRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/salon", name="admin.salon.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $salons = $this->repository->findAll();
        return $this->render('admin/salon/index.html.twig', compact('salons'));
    }

    /**
     * @Route("/admin/salon/{id}/list", name="admin.salon.list")
     * @return Response
     * @param Salon $salon
     */
    public function list(Salon $salon): Response
    {
        return $this->render('admin/salon/list.html.twig', [
            'salon' => $salon,
            'current_menu' => 'salons',
        ]);
    }

    /**
     * @Route("/admin/salon/create", name="admin.salon.new")
     */
    public function new(Request $request)
    {
        $salon = new Salon();
        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($salon);
            $this->em->flush();
            $this->addFlash('success', 'Salon ajouté avec succès');
            return $this->redirectToRoute('admin.salon.index');
        }

        return $this->render('admin/salon/new.html.twig', [
            'salon' => $salon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/salon/{id}", name="admin.salon.edit")
     * @param Salon $salon
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Salon $salon, Request $request, CacheManager $cacheManager, UploaderHelper $helper)
    {
        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Salon modifié avec succès');
            return $this->redirectToRoute('admin.salon.index');
        }

        return $this->render('admin/salon/edit.html.twig', [
            'salon' => $salon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/salon/{id}", name="admin.salon.delete", methods="DELETE")
     * @param Salon $salon
     * @return Response
     */
    public function delete(Salon $salon, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $salon->getId(), $request->get('_token'))) {
            $this->em->remove($salon);
            $this->addFlash('success', 'Salon supprimé avec succès');
            $this->em->flush();
        }
        return $this->redirectToRoute('admin.salon.index');
    }

    /**
     * @Route("/admin/salon/{id}/calendar", name="admin.salon.calendar")
     * @param Salon $salon
     * @return Response
     */
    public function calendar(Salon $salon): Response
    {
        return $this->render('admin/salon/calendar.html.twig', [
            'salon' => $salon,
            'current_menu' => 'salons',
        ]);
    }
}
