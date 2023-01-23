<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class ErrorController extends AbstractController
{
    
    public function handleError(Request $request, FlattenException $exception)
    {
        switch ($exception->getStatusCode()) {
            case 404:
                return $this->redirectToRoute('error_404');
                break;
            case 403:
                return $this->redirectToRoute('error_403');
                break;
            default:
                return $this->render('error/error.html.twig', [
                    'status_code' => $exception->getStatusCode(),
                    'status_text' => $exception->getMessage(),
                ]);
                break;
        }
    }

    /**
     * @Route("/error/404", name="error_404")
     */
    public function error404()
    {
        return $this->render('error/404.html.twig');
    }

    /**
     * @Route("/error/403", name="error_403")
     */
    public function error403()
    {
        return $this->render('error/403.html.twig');
    }
}

