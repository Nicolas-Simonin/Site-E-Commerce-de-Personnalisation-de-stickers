<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormPDFController extends AbstractController
{
    /**
     * @Route("/form/pdf", name="app_formPDF")
     * @param Request $request
     * @return Response
     */
    public function homepage(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('pdf.html.twig');
    }
}