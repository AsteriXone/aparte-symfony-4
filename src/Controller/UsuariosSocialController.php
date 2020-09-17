<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class UsuariosSocialController extends AbstractController
{
    /**
     * @Route("/usuario-reportaje/galeria", name="galeria-social")
     */
    public function usuarioSocialGaleriaAction(Request $request)
    {
        // Obtener Administrador del usuario
        $administrador = $this->getUser()->getUserSocial()->getGrupoSocial()->getUserAdmin()->getUser()->getEmail();
        $ruta = '';
        if ($administrador == 'rubenrueda80@gmail.com'){
            $ruta = $this->getParameter('ricardo_directory');
        } else if ($administrador == 'sevilla@apartefotografia.es'){
            $ruta = $this->getParameter('ricardo_directory');
        } else if ($administrador == 'info@apartefotografia.es'){
            $ruta = $this->getParameter('andres_directory');
        }
        $user = $this->getUSer();
        $carpeta_usuario = $user->getNombre()."_".$user->getApellido1()."_".$user->getApellido2()."_".$user->getId();

        $rutaFinal = $ruta.'/'.$carpeta_usuario;
        // Obtener Directorios del administrador del usuario
        $carpetas = new Finder();
        $carpetas->directories()->in($rutaFinal)->sortByName();

        $carpetasVista = null;

        foreach ($carpetas as $carpeta) {
            // Relative path to the directories
            // var_dump($carpeta->getRelativePathname());
            $carpetasVista[] = $carpeta->getRelativePathname();
        }
        return $this->render('social/galeria-usuario-social.html.twig', [
            'carpetas' => $carpetasVista,
        ]);
    }

    /**
     * @Route("/usuario-reportaje/galeria/{slug}", name="galeria-social-carpeta")
     */
    public function usuarioSocialGaleriaCarpetaAction(Request $request, $slug)
    {
        // Obtener Administrador del usuario
        $administrador = $this->getUser()->getUserSocial()->getGrupoSocial()->getUserAdmin()->getUser()->getEmail();
        $ruta = '';
        if ($administrador == 'rubenrueda80@gmail.com'){
            $ruta = $this->getParameter('ruben_directory');
            $rutaAdmin = 'ruben';
        } else if ($administrador == 'sevilla@apartefotografia.es'){
            $ruta = $this->getParameter('ricardo_directory');
            $rutaAdmin = 'ricardo';
        } else if ($administrador == 'info@apartefotografia.es'){
            $ruta = $this->getParameter('andres_directory');
            $rutaAdmin = 'andres';
        }
        $user = $this->getUSer();
        $carpeta_usuario = $user->getNombre()."_".$user->getApellido1()."_".$user->getApellido2()."_".$user->getId();

        $rutaFinal = $ruta.'/'.$carpeta_usuario.'/'.$slug;

        // Obtener archivos carpeta accedida usuario
        $archivos = new Finder();
        $archivos->files()->in($rutaFinal)->sortByName();

        $archivosVista = null;

        foreach ($archivos as $archivo) {
            // Relative path to the directories
            // var_dump($carpeta->getRelativePathname());
            $archivosVista[] = $archivo->getRelativePathname();
        }
        return $this->render('social/galeria-usuario-social-carpeta.html.twig', [
            'imagenes' => $archivosVista,
            'admin' => $rutaAdmin,
            'usuario' => $carpeta_usuario,
            'carpeta' => $slug,
        ]);
    }
}
