<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\MuestrasCarreraGrupoCarrera;

class ProductosCarreraController extends AbstractController
{
    /**
     * @Route("/usuario-carrera/productos", name="productos-carrera")
     */
    public function productosCarreraAction(Request $request)
    {
        // Getting useAdmin
        $grupo = $this->getUser()
            ->getUserCarrera()
            ->getGrupoCarrera();
        $muestras = $this->getDoctrine()
        // TODO: Obtener Productos
        ->getRepository(MuestrasCarreraGrupoCarrera::class)
        ->findBy([
            'grupo_carrera' => $grupo,
        ]);


        return $this->render('default/productos-carrera.html.twig',
            [
                'muestras' => $muestras,
            ]
        );
    }
}
