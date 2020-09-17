<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Galeria;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
     * @Route("/download/guia", name="guia")
     */
    public function guiaAction(Request $request)
    {
        $response = new BinaryFileResponse($this->getParameter('guia_directory').'/guia_como_llegar.pdf');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,'guia_como_llegar.pdf');
        return $response;
        // // Obtener guia
        // $samplePdf = new File($this->getParameter('guia_directory').'/guia_como_llegar.pdf');
        // return $this->file($samplePdf);
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
     * @Route("/galeria-academica/{slug}", name="galeria-academica")
     */
    public function galeriaAcademicaAction(Request $request, $slug)
    {
        $galeria = $this->getDoctrine()
        ->getRepository(Galeria::class)
        ->findOneBy([
            'id' => $slug,
            'tipo_galleria' => 'Académica'
        ]);
        return $this->render('default/galeria.html.twig',
            [
                'academica' => true,
                'galeria' => $galeria
            ]
        );
    }

    /**
     * @Route("/galeria-social/{slug}", name="galeria-social")
     */
    public function galeriaSocialAction(Request $request, $slug)
    {
        $galeria = $this->getDoctrine()
        ->getRepository(Galeria::class)
        ->findOneBy([
            'id' => $slug,
            'tipo_galleria' => 'Social'
        ]);
        return $this->render('default/galeria.html.twig',
            [
                'social' => true,
                'galeria' => $galeria
            ]
        );
    }

    /**
     * @Route("/resenia", name="resenia-no-loggin")
     */
    public function reseniaNoLogginAction(Request $request)
    {
        // TODO: Resenias usuarios o logueados
        // Introducir codigo grupo
        // Existe codigo grupo -> Puede dejar reseña
        // No existe codigo grupo -> Mensaje error
        // END-TODO


        if ($request->getMethod()=="GET"){
            // Get Method
            return $this->render('default/resenia.html.twig');
        } else {
            // Post Method
            $calidad = $request->request->get('calidad');
            $ambiente = $request->request->get('ambiente');
            $trato = $request->request->get('trato');
            $accesibilidad = $request->request->get('accesibilidad');
            $disenio = $request->request->get('disenio');
            $comentario = $request->request->get('comentario');

            if (!$calidad){
                $calidad = 0;
            }
            if (!$ambiente){
                $ambiente = 0;
            }
            if (!$trato){
                $trato = 0;
            }
            if (!$accesibilidad){
                $accesibilidad = 0;
            }
            if (!$disenio){
                $disenio = 0;
            }
            if (!$comentario){
                $isPublicada = 0;
                $comentario = "No dejó comentario, no se publicará!";
            } else {
                $isPublicada = 1;
            }
            // Crea nueva resenia
            $resenia = new Resegnia();
            $resenia->setCalidadPrecio($calidad);
            $resenia->setAmbiente($ambiente);
            $resenia->setTrato($trato);
            $resenia->setAccesibilidad($accesibilidad);
            $resenia->setDisegnioOpciones($disenio);
            $resenia->setComentario($comentario);
            $resenia->setPublicada($isPublicada);

            // TODO: Ver como solucionamos tema usuario
            $resenia->setUserCarrera($this->getUser()->getUserCarrera());

            $resenia->setFechaPublicacion(new \DateTime('now'));
            // insert to DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resenia);
            $entityManager->flush();

            return $this->render('default/resenia-enviada.html.twig', ['mensaje']);
        }
        return $this->render('default/resenia.html.twig');
    }
}
