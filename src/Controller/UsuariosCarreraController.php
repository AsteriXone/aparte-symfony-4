<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\VotacionesProfesorCarrera;

class UsuariosCarreraController extends AbstractController
{
    /**
     * @Route("/usuario-carrera/votar-profesores", name="carrera-votar-profesores")
     */
    public function votarProfesoresAction(Request $request)
    {
        // Comprobar grupo activo
        if ($request->getMethod()=="GET"){
            // Method GET
            $grupoIsActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsActive();
            if ($grupoIsActive){
                // Grupo Activo
                // Comprueba si votaciones activa
                $votacionesIsActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsVotacionesActive();
                if ($votacionesIsActive){
                    // Votaciones Activas
                    // Obtener profesores del grupo
                    $profesoresGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getProfesoresGruposCarrera();
                    // Obtener numero de votos numeroVotosPosible
                    $numeroVotos = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getNumeroMaximoVotarProfes();
                    // Comprobar si cada profesor ya ha sido votado por el usuario
                    foreach ($profesoresGrupoCarrera as $profesorGrupoCarrera) {
                        $votacionProfe = $this->getDoctrine()
                        ->getRepository(VotacionesProfesorCarrera::class)
                        ->findOneBy([
                            'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                            'profesor_carrera' => $profesorGrupoCarrera->getProfesorCarrera()->getId()
                        ]);
                        if ($votacionProfe){
                            // Existe votacion
                            $profesorGrupoCarrera->getProfesorCarrera()->setIsVotado(true);
                        }
                    }
                } else {
                    // Votaciones desactivadas
                    $profesoresGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getProfesoresGruposCarrera();
                    // Comprobar si cada profesor ya ha sido votado por el usuario
                    foreach ($profesoresGrupoCarrera as $profesorGrupoCarrera) {
                        $votacionProfe = $this->getDoctrine()
                        ->getRepository(VotacionesProfesorCarrera::class)
                        ->findOneBy([
                            'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                            'profesor_carrera' => $profesorGrupoCarrera->getProfesorCarrera()->getId()
                        ]);
                        if ($votacionProfe){
                            // Existe votacion
                            $profesorGrupoCarrera->getProfesorCarrera()->setIsVotado(true);
                        }
                    }
                    return $this->render('usuarios_carrera/votar-profesores.html.twig', [
                        'profesoresGrupoCarrera' => $profesoresGrupoCarrera,
                        'votoDesactivado' => true
                    ]);

                }
            } else {
                // Grupo Desactivado
                return $this->render('usuarios_carrera/votar-profesores.html.twig', [
                    'grupoDesactivado' => true
                ]);
            }

            return $this->render('usuarios_carrera/votar-profesores.html.twig', [
                'profesoresGrupoCarrera' => $profesoresGrupoCarrera,
                'numeroVotosPosible' => $numeroVotos
            ]);
        } else {
            // Method POST
            $profesoresGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getProfesoresGruposCarrera();
            // Recorrer profesores del grupo
            foreach ($profesoresGrupoCarrera as $profesorGrupoCarrera) {
                $idProfesor = $profesorGrupoCarrera->getProfesorCarrera()->getId();
                $estadoProfesorFormulario = $request->request->get($idProfesor);

                if ($estadoProfesorFormulario){
                    // Seleccionado en formulario
                    // Comprueba si votacion no esta registrada en DB
                    $votacionProfe = $this->getDoctrine()
                    ->getRepository(VotacionesProfesorCarrera::class)
                    ->findOneBy([
                        'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                        'profesor_carrera' => $idProfesor
                    ]);
                    if (!$votacionProfe){
                        // No existe votacion, registrar en DB
                        $votoProfesorCarrera = new VotacionesProfesorCarrera();
                        $votoProfesorCarrera->setUserCarrera($this->getUser()->getUserCarrera());
                        $votoProfesorCarrera->setProfesorCarrera($profesorGrupoCarrera->getProfesorCarrera());
                        // insert to DB
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($votoProfesorCarrera);
                        $entityManager->flush();
                    }
                    $profesorGrupoCarrera->getProfesorCarrera()->setIsVotado(true);
                } else {
                    // No seleccionado en formulario
                    // Comprueba si votacion esta registrada en DB
                    $votacionProfe = $this->getDoctrine()
                    ->getRepository(VotacionesProfesorCarrera::class)
                    ->findOneBy([
                        'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                        'profesor_carrera' => $idProfesor
                    ]);
                    if ($votacionProfe){
                        // Existe votacion, eliminar de DB

                        // remove from DB
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($votacionProfe);
                        $entityManager->flush();
                    }
                    $profesorGrupoCarrera->getProfesorCarrera()->setIsVotado(false);
                }
            }
            
            $mensaje = "Tus votación se han guardado correctamente!";
            return $this->render('usuarios_carrera/votar-profesores.html.twig', [
                'profesoresGrupoCarrera' => $profesoresGrupoCarrera,
                'mensaje' => $mensaje
            ]);

        }

    }
}
