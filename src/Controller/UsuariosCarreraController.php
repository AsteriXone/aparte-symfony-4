<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\VotacionesProfesorCarrera;
use App\Entity\VotacionesMuestraCarrera;
use App\Entity\VotacionesColorBecaCarrera;
use App\Entity\CitasFechaCuadranteGrupoCarrera;
use App\Entity\Resegnia;

class UsuariosCarreraController extends AbstractController
{
    /**
     * @Route("/usuario-carrera/orla-provisional", name="orla-provisional-grupo-carrera")
     */
    public function orlaProvisionalGrupoCarreraAction(Request $request)
    {
        // Getting useAdmin
        $orlasProvisional = $this->getUser()
            ->getUserCarrera()
            ->getGrupoCarrera()
            ->getOrlasProvisionalGrupoCarreras();
            dump($orlasProvisional);
        if ($orlasProvisional){
            return $this->render('usuarios_carrera/orla-provisional.html.twig', ['orlas_provisionales' => $orlasProvisional]);
        } else {
            return $this->render('usuarios_carrera/no-hay-orla-provisional.html.twig');
        }
    }

    /**
     * @Route("/usuario-carrera/estado-orla", name="estado-orla-grupo")
     */
    public function estadoOrlaAction(Request $request)
    {
        $estadoOrla = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getProcesoOrlaGrupo()->getEstado();
        $dia = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getProcesoOrlaGrupo()->getFechaEntrega();
        $tipo = 'progress-bar-striped progress-bar-animated';
        if (!$dia){
            // No hay fecha
            $fecha = "sin determinar!";
        } else {
            $fecha = $dia->format('d/m/Y');
        }
        if ($estadoOrla == "Sin estado"){
            $estado = 0;
            $mensajeEstado = "Tu orla aún no tiene estado";
            $color = '';
        } else if ($estadoOrla == "sesion"){
            $estado = 16;
            $mensajeEstado = "Sesión de fotos activa";
            $color = 'bg-danger';
        } else if ($estadoOrla == "nombrado"){
            $estado = 33;
            $mensajeEstado = "Estamos nombrando las fotografías";
            $color = 'bg-warning';
        } else if ($estadoOrla == "retoque"){
            $estado = 50;
            $mensajeEstado = "Las fotos se están retocando";
            $color = 'bg-warning';
        } else if ($estadoOrla == "montaje"){
            $estado = 66;
            $mensajeEstado = "Estamos montando la orla";
            $color = 'bg-info';
        } else if ($estadoOrla == "correccion"){
            $estado = 83;
            $mensajeEstado = "Es momento de correcciones";
            $color = '';
        } else if ($estadoOrla == "entregada"){
            $estado = 100;
            $mensajeEstado = "Orla entregada con fecha ".$fecha;
            $color = 'bg-success';
            $tipo = '';
        } else {
            $estado = 0;
            $mensajeEstado = "El estado de tu orla está sin determinar";
            $color = 'bg-dark';
        }
        return $this->render('usuarios_carrera/estado-orla.html.twig', ['estado' => $estado, 'mensajeEstado' => $mensajeEstado, 'color'=>$color, 'tipo' => $tipo ]);
    }
    /**
     * @Route("/usuario-carrera/resenia", name="resenia")
     */
    public function reseniaAction(Request $request)
    {
        // Comprobar si usuario dejó reseña
        $resenia = $this->getUser()->getUserCarrera()->getResegnia();
        $grupoIsActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsActive();

        if ($request->getMethod()=="GET"){
            // Get Method
            if ($resenia){
                // Hay reseña de user
                $calidad = $resenia->getCalidadPrecio();
                $ambiente = $resenia->getAmbiente();
                $trato = $resenia->getTrato();
                $accesibilidad = $resenia->getAccesibilidad();
                $disenio = $resenia->getDisegnioOpciones();
                $comentario = $resenia->getComentario();
                return $this->render('usuarios_carrera/resenia.html.twig',
                    [
                        'calidad' => $calidad,
                        'ambiente' => $ambiente,
                        'trato' => $trato,
                        'accesibilidad' => $accesibilidad,
                        'disenio' => $disenio,
                        'comentario' => $comentario
                    ]);
            } else{
                // No hay reseña de user
                return $this->render('usuarios_carrera/resenia.html.twig');
            }
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

            // Comprobar si usuario dejó reseña
            $resenia = $this->getUser()->getUserCarrera()->getResegnia();

            if ($resenia){
                // Existe reseña -> actualiza
                $resenia->setCalidadPrecio($calidad);
                $resenia->setAmbiente($ambiente);
                $resenia->setTrato($trato);
                $resenia->setAccesibilidad($accesibilidad);
                $resenia->setDisegnioOpciones($disenio);
                $resenia->setComentario($comentario);
                $resenia->setPublicada($isPublicada);
                $resenia->setUserCarrera($this->getUser()->getUserCarrera());
                $resenia->setFechaPublicacion(new \DateTime('now'));
                // insert to DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($resenia);
                $entityManager->flush();
            } else {
                // No existe reseña -> crea nueva
                $resenia = new Resegnia();
                $resenia->setCalidadPrecio($calidad);
                $resenia->setAmbiente($ambiente);
                $resenia->setTrato($trato);
                $resenia->setAccesibilidad($accesibilidad);
                $resenia->setDisegnioOpciones($disenio);
                $resenia->setComentario($comentario);
                $resenia->setPublicada($isPublicada);
                $resenia->setUserCarrera($this->getUser()->getUserCarrera());
                $resenia->setFechaPublicacion(new \DateTime('now'));
                // insert to DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($resenia);
                $entityManager->flush();
            }
            return $this->render('usuarios_carrera/resenia-enviada.html.twig', ['mensaje']);
        }

        // $isContratoActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsContratoActive();
        // if ($isContratoActive){
        //     $contratoPath = $this->getParameter('contratos_directory').'/'.$contrato;
        //     return $this->file($contratoPath);
        // } else {
        //     return $this->render('usuarios_carrera/no-contrato.html.twig');
        // }
        return $this->render('usuarios_carrera/resenia.html.twig');
    }

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

                // Comprueba si usuario bloqueado
                $bloqueado = $this->getUser()->getUserCarrera()->getIsVotarCitasActive();

                if ($bloqueado){
                    // Usuario Bloqueado
                    return $this->render('usuarios_carrera/usuario-bloqueado.html.twig');
                } else {
                    // Usuario No Bloqueado
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
                // Comprueba si usuario Bloqueado
                $bloqueado = $this->getUser()->getUserCarrera()->getIsVotarCitasActive();
                if ($bloqueado){
                    // Usuario Bloqueado
                    return $this->render('usuarios_carrera/usuario-bloqueado.html.twig');
                } else {
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
            // Comprueba si usuario Bloqueado
            $bloqueado = $this->getUser()->getUserCarrera()->getIsVotarCitasActive();
            if ($bloqueado){
                // Usuario Bloqueado
                return $this->render('usuarios_carrera/usuario-bloqueado.html.twig');
            } else {
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

    /**
     * @Route("/usuario-carrera/votar-becas", name="carrera-votar-becas")
     */
    public function votarBecasAction(Request $request)
    {
        // Comprobar grupo activo
        if ($request->getMethod()=="GET"){
            // Method GET
            $grupoIsActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsActive();
            if ($grupoIsActive){
                // Grupo Activo
                $bloqueado = $this->getUser()->getUserCarrera()->getIsVotarCitasActive();
                if ($bloqueado){
                    // Usuario Bloqueado
                    return $this->render('usuarios_carrera/usuario-bloqueado.html.twig');
                } else {
                    // Comprueba si votaciones activa
                    $votacionesIsActive = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getIsVotacionesActive();
                    if ($votacionesIsActive){
                        // Votaciones Activas
                        // Obtener profesores del grupo
                        $colorBecasGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getColorBecaCarreraGruposCarrera();
                        // Obtener numero de votos numeroVotosPosible
                        $numeroVotos = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getNumeroMaximoVotarColorBecas();
                        // Comprobar si cada profesor ya ha sido votado por el usuario
                        foreach ($colorBecasGrupoCarrera as $colorBecaGrupoCarrera) {
                            $votacionColorBeca = $this->getDoctrine()
                            ->getRepository(VotacionesColorBecaCarrera::class)
                            ->findOneBy([
                                'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                                'colorBeca_carrera' => $colorBecaGrupoCarrera->getColorBecasCarrera()->getId()
                            ]);
                            if ($votacionColorBeca){
                                // Existe votacion
                                $colorBecaGrupoCarrera->getColorBecasCarrera()->setIsVotado(true);
                            }
                        }
                    } else {
                        // Votaciones desactivadas
                        $colorBecasGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getColorBecaCarreraGruposCarrera();
                        // Comprobar si cada colorBeca ya ha sido votado por el usuario
                        foreach ($colorBecasGrupoCarrera as $colorBecaGrupoCarrera) {
                            $votacionColorBeca = $this->getDoctrine()
                            ->getRepository(VotacionesColorBecaCarrera::class)
                            ->findOneBy([
                                'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                                'colorBeca_carrera' => $colorBecaGrupoCarrera->getColorBecasCarrera()->getId()
                            ]);
                            if ($votacionColorBeca){
                                // Existe votacion
                                $colorBecaGrupoCarrera->getColorBecasCarrera()->setIsVotado(true);
                            }
                        }
                        return $this->render('usuarios_carrera/votar-colorBecas.html.twig', [
                            'colorBecasGrupoCarrera' => $colorBecasGrupoCarrera,
                            'votoDesactivado' => true
                        ]);

                    }
                }

            } else {
                // Grupo Desactivado
                return $this->render('usuarios_carrera/votar-colorBecas.html.twig', [
                    'grupoDesactivado' => true
                ]);
            }
            return $this->render('usuarios_carrera/votar-colorBecas.html.twig', [
                'colorBecasGrupoCarrera' => $colorBecasGrupoCarrera,
                'numeroVotosPosible' => $numeroVotos
            ]);
        } else {
            // Method POST
            $colorBecasGrupoCarrera = $this->getUser()->getUserCarrera()->getGrupoCarrera()->getColorBecaCarreraGruposCarrera();
            // Recorrer profesores del grupo
            foreach ($colorBecasGrupoCarrera as $colorBecaGrupoCarrera) {
                $idColorBeca = $colorBecaGrupoCarrera->getColorBecasCarrera()->getId();
                $estadoColorBecaFormulario = $request->request->get($idColorBeca);
                if ($estadoColorBecaFormulario){
                    // Seleccionado en formulario
                    // Comprueba si votacion no esta registrada en DB
                    $votacionColorBeca = $this->getDoctrine()
                    ->getRepository(VotacionesColorBecaCarrera::class)
                    ->findOneBy([
                        'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                        'colorBeca_carrera' => $idColorBeca
                    ]);
                    if (!$votacionColorBeca){
                        // No existe votacion, registrar en DB
                        $votoColorBecaCarrera = new VotacionesColorBecaCarrera();
                        $votoColorBecaCarrera->setUserCarrera($this->getUser()->getUserCarrera());
                        $votoColorBecaCarrera->setColorBecaCarrera($colorBecaGrupoCarrera->getColorBecasCarrera());
                        // insert to DB
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($votoColorBecaCarrera);
                        $entityManager->flush();
                        // Aumentar voto en ColorBecasCarreraGrupoCarrera
                        $votosActuales = $colorBecaGrupoCarrera->getVotos();
                        // dump('Votos: '.$votosActuales);
                        $colorBecaGrupoCarrera->setVotos($votosActuales + 1);
                        $entityManager->persist($colorBecaGrupoCarrera);
                        $entityManager->flush();
                    }
                    $colorBecaGrupoCarrera->getColorBecasCarrera()->setIsVotado(true);
                } else {
                    // No seleccionado en formulario
                    // Comprueba si votacion esta registrada en DB
                    $votacionColorBeca = $this->getDoctrine()
                    ->getRepository(VotacionesColorBecaCarrera::class)
                    ->findOneBy([
                        'user_carrera' => $this->getUser()->getUserCarrera()->getId(),
                        'colorBeca_carrera' => $idColorBeca
                    ]);
                    if ($votacionColorBeca){
                        // Existe votacion, eliminar de DB

                        // remove from DB
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($votacionColorBeca);
                        $entityManager->flush();

                        // TODO: Disminuir voto en ProfesorGrupoCarrera
                        $votosActuales = $colorBecaGrupoCarrera->getVotos();
                        $colorBecaGrupoCarrera->setVotos($votosActuales - 1);
                        $entityManager->persist($colorBecaGrupoCarrera);
                        $entityManager->flush();

                    }
                    $colorBecaGrupoCarrera->getColorBecasCarrera()->setIsVotado(false);
                }
            }

            $mensaje = "Tu votación ha sido registrada correctamente!";
            return $this->render('usuarios_carrera/votar-colorBecas-guardado.html.twig', [
                'colorBecasGrupoCarrera' => $colorBecasGrupoCarrera,
                'mensaje' => $mensaje
            ]);
        }
    }
}
