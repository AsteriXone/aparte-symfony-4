<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/foto-academica", name="foto-academica")
     */
    public function academicaAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/foto-academica-index.html.twig',
            ['academica' => true]
        );
    }

    /**
     * @Route("/social", name="foto-social")
     */
    public function fotoSocialAction(Request $request)
    {
        // TODO: Diseño página foto-social-index.html.twig
        return $this->render('default/foto-social-index.html.twig',
            ['social' => true]
        );
    }

    /**
     * @Route("/contactar", name="contactar")
     */
    public function contactarAction(Request $request)
    {
        // TODO: Formulario en contactar.html.twig
        return $this->render('default/contactar.html.twig');
    }

    /**
     * @Route("/galeria-academica", name="galeria-academica")
     */
    public function galeriaAcademicaAction(Request $request)
    {
        return $this->render('default/galeria.html.twig',
            ['academica' => true]
        );
    }

    /**
     * @Route("/galeria-social", name="galeria-social")
     */
    public function galeriaSocialAction(Request $request)
    {
        return $this->render('default/galeria.html.twig',
            ['social' => true]
        );
    }
}
