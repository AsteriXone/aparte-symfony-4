<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\MuestrasCarreraGrupoCarrera;

class MuestrasCarreraController extends AbstractController
{
    /**
     * @Route("/usuario-carrera/muestras", name="muestras-carrera")
     */
    public function muestrasCarreraAction(Request $request)
    {
        // Getting useAdmin
        $grupo = $this->getUser()
            ->getUserCarrera()
            ->getGrupoCarrera();
        $muestras = $this->getDoctrine()
        ->getRepository(MuestrasCarreraGrupoCarrera::class)
        ->findBy([
            'grupo_carrera' => $grupo,
        ]);


        return $this->render('default/muestras-carrera.html.twig',
            [
                'muestras' => $muestras,
            ]
        );
    }
}
