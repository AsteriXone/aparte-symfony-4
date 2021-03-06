<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Galeria;
use App\Entity\User;
use App\Entity\Resegnia;
use App\Entity\GrupoSocial;
use App\Entity\GrupoCarrera;


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
     * @Route("/galeria-social/{slug}", name="galeria-social-imagenes")
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
     * @Route("/resegnia", name="resenias-not-login")
     */
    public function reseniaNoLogginAction(Request $request)
    {
        if ($request->getMethod()=="GET"){
            // Get Method
            return $this->render('default/resenia.html.twig');
        } else {
            // Post Method
            $nombre = $request->request->get('nombre');
            $email = $request->request->get('correo');
            $codigoGrupo = $request->request->get('codigo');
            $calidad = $request->request->get('calidad');
            $ambiente = $request->request->get('ambiente');
            $trato = $request->request->get('trato');
            $accesibilidad = $request->request->get('accesibilidad');
            $disenio = $request->request->get('disenio');
            $comentario = $request->request->get('comentario');
            $code_error = null;

            // Comprobar $email
            $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'email' => $email,
            ]);

            if (!$user){
                // No existe $email
                $mail_error = "Correo incorrecto!";
                return $this->render('default/resenia.html.twig', [ 'mail_error' => $mail_error, 'nombre' => $nombre ]);
            } else {
                // Email valido
                // Comprobar codigoGrupo
                if ($codigoGrupo){
                    $tipoGrupo = "";
                    // Busca en grupoSocial
                    $grupoSocial = $this->getDoctrine()
                    ->getRepository(GrupoSocial::class)
                    ->findOneBy(['codigo_grupo' => $codigoGrupo]);
                    if ($grupoSocial){
                        $tipoGrupo = 'social';
                    } else {
                        // Busca en grupoCarrera
                        $grupoCarrera = $this->getDoctrine()
                        ->getRepository(GrupoCarrera::class)
                        ->findOneBy(['codigo_grupo' => $codigoGrupo]);
                        if ($grupoCarrera){
                          $tipoGrupo = 'carrera';
                        } else {
                          //
                        }
                    }

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

                    // Comprobamos si user ya tiene resenia

                    $reseniaAux = null;
                    if ($tipoGrupo == 'social'){
                        // Comprueba si userSocial ya puso reseña
                        $reseniaAux = $this->getDoctrine()
                        ->getRepository(Resegnia::class)
                        ->findOneBy(['user_social' => $user->getUserSocial()]);
                    } elseif ($tipoGrupo == 'carrera'){
                        // Comprueba si userCarrera ya puso reseña
                        $reseniaAux = $this->getDoctrine()
                        ->getRepository(Resegnia::class)
                        ->findOneBy(['user_carrera' => $user->getUserCarrera()]);
                    }
                    if($reseniaAux){
                        // Si existe resenia la borra
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($reseniaAux);
                        $entityManager->flush();
                    }

                    $resenia = new Resegnia();
                    $resenia->setCalidadPrecio($calidad);
                    $resenia->setAmbiente($ambiente);
                    $resenia->setTrato($trato);
                    $resenia->setAccesibilidad($accesibilidad);
                    $resenia->setDisegnioOpciones($disenio);
                    $resenia->setComentario($comentario);
                    // Publicada segun deje comentario o no
                    $resenia->setPublicada($isPublicada);
                    $resenia->setFechaPublicacion(new \DateTime('now'));

                    if ($tipoGrupo == 'social'){
                        $user->getUserSocial()->setResegnia($resenia);
                        // insert to DB
                        if(!$code_error){
                          $entityManager = $this->getDoctrine()->getManager();
                          $entityManager->flush();
                          return $this->render('default/resenia-enviada.html.twig', ['mensaje']);
                        }
                    } elseif ($tipoGrupo == 'carrera'){
                        $user->getUserCarrera()->setResegnia($resenia);
                        if(!$code_error){
                          $entityManager = $this->getDoctrine()->getManager();
                          $entityManager->flush();
                          return $this->render('default/resenia-enviada.html.twig', ['mensaje']);
                        }
                    } else {
                      // Se ha enviado codigo de grupo pero no coincide en DB
                      $code_error = "Código de grupo no válido!";
                      return $this->render('default/resenia.html.twig', [ 'code_error' => $code_error, 'email' => $email, 'nombre' => $nombre ]);
                    }

              } else {
                // No se ha enviado codigo de grupo
                $code_error = "Debe introducir código de grupo!";
                return $this->render('default/resenia.html.twig', [ 'code_error' => $code_error, 'email' => $email, 'nombre' => $nombre ]);
              }
            }
        }
    }
}
