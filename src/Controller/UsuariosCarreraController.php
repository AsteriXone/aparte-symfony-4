<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\VotacionesProfesorCarrera;
use App\Entity\VotacionesMuestraCarrera;
use App\Entity\CitasFechaCuadranteGrupoCarrera;

class UsuariosCarreraController extends AbstractController
{
    /**
     * @Route("/usuario-carrera/contrato", name="contrato")
     */
    public function contratoAction(Request $request)
    {
        // Obtener contrato para grupo
        $contrato = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getContrato();
        $isContratoActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsContratoActive();
        if ($isContratoActive){
            $contratoPath = $this->getParameter('contratos_directory').'/'.$contrato;
            return $this->file($contratoPath);
        } else {
            return $this->render('usuarios_carrera/no-contrato.html.twig');
        }
    }

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
                        // TODO: Aumentar voto en ProfesorGrupoCarrera
                        $votosActuales = $profesorGrupoCarrera->getVotos();

                        $profesorGrupoCarrera->setVotos($votosActuales + 1);
                        $entityManager->persist($profesorGrupoCarrera);
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

                        // TODO: Disminuir voto en ProfesorGrupoCarrera
                        $votosActuales = $profesorGrupoCarrera->getVotos();
                        $profesorGrupoCarrera->setVotos($votosActuales - 1);
                        $entityManager->persist($profesorGrupoCarrera);
                        $entityManager->flush();

                    }
                    $profesorGrupoCarrera->getProfesorCarrera()->setIsVotado(false);
                }
            }

            $mensaje = "Tus votación se han guardado correctamente!";
            return $this->render('usuarios_carrera/votar-profes-guardado.html.twig', [
                'profesoresGrupoCarrera' => $profesoresGrupoCarrera,
                'mensaje' => $mensaje
            ]);

        }

    }

    /**
     * @Route("/usuario-carrera/votar-muestras", name="carrera-votar-muestras")
     */
    public function votarMuestrasAction(Request $request)
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
                    $muestrasGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getMuestraCarreraGruposCarrera();
                    // Obtener numero de votos numeroVotosPosible
                    $numeroVotos = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getNumeroMaximoVotarOrlas();
                    // Comprobar si cada profesor ya ha sido votado por el usuario
                    foreach ($muestrasGrupoCarrera as $muestraGrupoCarrera) {
                        $votacionMuestra = $this->getDoctrine()
                        ->getRepository(VotacionesMuestraCarrera::class)
                        ->findOneBy([
                            'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                            'muestra_carrera' => $muestraGrupoCarrera->getMuestrasCarrera()->getId()
                        ]);
                        if ($votacionMuestra){
                            // Existe votacion
                            $muestraGrupoCarrera->getMuestrasCarrera()->setIsVotado(true);
                        }
                    }
                } else {
                    // Votaciones desactivadas
                    $muestrasGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getMuestraCarreraGruposCarrera();
                    // Comprobar si cada muestra ya ha sido votado por el usuario
                    foreach ($muestrasGrupoCarrera as $muestraGrupoCarrera) {
                        $votacionMuestra = $this->getDoctrine()
                        ->getRepository(VotacionesMuestraCarrera::class)
                        ->findOneBy([
                            'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                            'muestra_carrera' => $muestraGrupoCarrera->getMuestrasCarrera()->getId()
                        ]);
                        if ($votacionMuestra){
                            // Existe votacion
                            $muestraGrupoCarrera->getMuestrasCarrera()->setIsVotado(true);
                        }
                    }
                    return $this->render('usuarios_carrera/votar-muestras.html.twig', [
                        'muestrasGrupoCarrera' => $muestrasGrupoCarrera,
                        'votoDesactivado' => true
                    ]);

                }
            } else {
                // Grupo Desactivado
                return $this->render('usuarios_carrera/votar-muestras.html.twig', [
                    'grupoDesactivado' => true
                ]);
            }

            return $this->render('usuarios_carrera/votar-muestras.html.twig', [
                'muestrasGrupoCarrera' => $muestrasGrupoCarrera,
                'numeroVotosPosible' => $numeroVotos
            ]);
        } else {
            // Method POST
            $muestrasGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getMuestraCarreraGruposCarrera();
            // Recorrer profesores del grupo
            foreach ($muestrasGrupoCarrera as $muestraGrupoCarrera) {
                $idMuestra = $muestraGrupoCarrera->getMuestrasCarrera()->getId();
                $estadoMuestraFormulario = $request->request->get($idMuestra);
                if ($estadoMuestraFormulario){
                    // Seleccionado en formulario
                    // Comprueba si votacion no esta registrada en DB
                    $votacionMuestra = $this->getDoctrine()
                    ->getRepository(VotacionesMuestraCarrera::class)
                    ->findOneBy([
                        'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                        'muestra_carrera' => $idMuestra
                    ]);
                    if (!$votacionMuestra){
                        // No existe votacion, registrar en DB
                        $votoMuestraCarrera = new VotacionesMuestraCarrera();
                        $votoMuestraCarrera->setUserCarrera($this->getUser()->getUserCarrera());
                        $votoMuestraCarrera->setMuestraCarrera($muestraGrupoCarrera->getMuestrasCarrera());
                        // insert to DB
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($votoMuestraCarrera);
                        $entityManager->flush();
                        // Aumentar voto en MuestrasCarreraGrupoCarrera
                        $votosActuales = $muestraGrupoCarrera->getVotos();
                        // dump('Votos: '.$votosActuales);
                        $muestraGrupoCarrera->setVotos($votosActuales + 1);
                        $entityManager->persist($muestraGrupoCarrera);
                        $entityManager->flush();
                    }
                    $muestraGrupoCarrera->getMuestrasCarrera()->setIsVotado(true);
                } else {
                    // No seleccionado en formulario
                    // Comprueba si votacion esta registrada en DB
                    $votacionMuestra = $this->getDoctrine()
                    ->getRepository(VotacionesMuestraCarrera::class)
                    ->findOneBy([
                        'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                        'muestra_carrera' => $idMuestra
                    ]);
                    if ($votacionMuestra){
                        // Existe votacion, eliminar de DB

                        // remove from DB
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($votacionMuestra);
                        $entityManager->flush();

                        // TODO: Disminuir voto en ProfesorGrupoCarrera
                        $votosActuales = $muestraGrupoCarrera->getVotos();
                        $muestraGrupoCarrera->setVotos($votosActuales - 1);
                        $entityManager->persist($muestraGrupoCarrera);
                        $entityManager->flush();

                    }
                    $muestraGrupoCarrera->getMuestrasCarrera()->setIsVotado(false);
                }
            }

            $mensaje = "Tu votación ha sido registrada correctamente!";
            return $this->render('usuarios_carrera/votar-muestras-guardado.html.twig', [
                'muestrasGrupoCarrera' => $muestrasGrupoCarrera,
                'mensaje' => $mensaje
            ]);
        }
    }

    /**
     * @Route("/usuario-carrera/citas", name="carrera-cita-usuario")
     */
    public function citasCarreraAction(Request $request)
    {
        $grupoIsActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsActive();
        $isCitasActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsCitasActive();
        if ($grupoIsActive){
            if ($isCitasActive){
                // Comprobar si user ha cogido cita, si no Mostrar citas
                $cita = $this->getDoctrine()
                ->getRepository(CitasFechaCuadranteGrupoCarrera::class)
                ->findOneBy([
                    'usuario' => $this->getUser()->getUserCarrera()
                ]);
                if ($cita){
                    return $this->render('usuarios_carrera/cita-actual.html.twig', [
                        'cita' => $cita
                    ]);
                } else {
                    // Obtener Citas para grupo
                    $cuadrantesGrupo = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getCuadrantesGruposCarreras();
                    // foreach ($cuadrantesGrupo as $cuadranteGrupo) {
                    //     dump($cuadranteGrupo->getCuadrante()->getNombreCuadrante());
                    // }
                    return $this->render('usuarios_carrera/solicitud-citas.html.twig', [
                        'cuadrantesGrupoCarrera' => $cuadrantesGrupo
                    ]);
                }
            } else {
                return $this->render('usuarios_carrera/solicitud-citas.html.twig', [
                    'citaDesactivado' => true
                ]);
            }
        } else {
            return $this->render('usuarios_carrera/solicitud-citas.html.twig', [
                'grupoDesactivado' => true
            ]);
        }
    }

    /**
     * @Route("/usuario-carrera/cita-aceptada", name="carrera-cita-usuario-aceptada")
     */
    public function citasCarreraAceptadaAction(Request $request)
    {
        if ($request->getMethod()=="POST"){
            $idCita = $request->request->get('cita');
            // dump($idCita);
            // Asegurar que cita no ha sido Ocupada
            $cita = $this->getDoctrine()
            ->getRepository(CitasFechaCuadranteGrupoCarrera::class)
            ->findOneBy([
                'id' => $idCita
            ]);
            if ($cita->getUsuario()){
                // Cita ocupada
                return $this->render('usuarios_carrera/cita-ocupada.html.twig', []);
            } else {
                // Guardar Citas
                $cita->setUsuario($this->getUser()->getUserCarrera());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cita);
                $entityManager->flush();
                return $this->render('usuarios_carrera/cita-aceptada.html.twig', [
                    'cita' => $cita
                ]);
            }
        }
    }

    /**
     * @Route("/usuario-carrera/cancelar-cita", name="cancelar-cita-carrera")
     */
    public function citasCarreraCancelarAction(Request $request)
    {
        $cita = $this->getDoctrine()
        ->getRepository(CitasFechaCuadranteGrupoCarrera::class)
        ->findOneBy([
            'usuario' => $this->getUser()->getUserCarrera()
        ]);
        $cita->setUsuario(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cita);
        $entityManager->flush();
        return $this->render('usuarios_carrera/cita-cancelada.html.twig', []);
    }
}
