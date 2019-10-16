<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\ProductosCarreraGrupoCarrera;

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
        $productos = $this->getDoctrine()
        // TODO: Obtener Productos
        ->getRepository(ProductosCarreraGrupoCarrera::class)
        ->findBy([
            'grupo_carrera' => $grupo,
        ]);


        return $this->render('default/productos-carrera.html.twig',
            [
                'productos' => $productos,
            ]
        );
    }
}
