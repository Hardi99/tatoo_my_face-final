<?php

namespace App\Controller;

use App\Entity\Salon;
use App\Entity\SalonSearch;
use App\Form\SalonSearchType;
use App\Repository\SalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class SalonController extends AbstractController
{
    /**
     * @var SalonRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(SalonRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/salons", name="salon.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new SalonSearch();
        $form = $this->createForm(SalonSearchType::class, $search);
        $form->handleRequest($request);

        $salons = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('salon/index.html.twig', [
            'current_menu' => 'salons',
            'salons'   => $salons,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/salons/{slug}-{id}", name="salon.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Salon $salon
     * @return Response
     */
    public function show(Salon $salon, string $slug): Response
    {
        if ($salon->getSlug() !== $slug) {
            $this->redirectToRoute('salon.show', [
                'id' => $salon->getId(),
                'slug' => $salon->getSlug()
            ], 301);
        }
        return $this->render('salon/show.html.twig', [
            'salon' => $salon,
            'current_menu' => 'salons'
        ]);
    }
}
