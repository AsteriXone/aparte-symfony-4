<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use App\Entity\CitasFechaCuadranteGrupoCarrera;

final class FechaCuadranteGrupoCarreraAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            ->add('cuadrante')
            ->add('fecha')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            // TODO: Sortable cuadrante column
            ->add('cuadrante', null, [
                'route'=>['name'=>''],
                'label'=>'Cuadrante',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'nombre_cuadrante'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'cuadrante'))
            ])
            ->add('fecha', 'date', ['format' => 'd-M-Y', 'label' => 'Fecha con citas abierta'])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    // 'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            // ->add('id')
            // TODO: Solo cuadrantes de Admin
            ->with('Cuadrante/Fecha', ['class' => 'col-md-4'])
                ->add('cuadrante')
                ->add('fecha', DatePickerType::class, ['format' => 'dd-MMMM-yyyy'])
            ->end()
            ->with('Tramo Citas', ['class' => 'col-md-4'])
                ->add('hIni', DateTimePickerType::class, [
                    'label' => 'Hora Inicio',
                    'dp_pick_date' => false,
                    'format' => 'HH:mm'
                ])
                ->add('hFin', DateTimePickerType::class, [
                    'label' => 'Hora Fin',
                    'dp_pick_date' => false,
                    'format' => 'HH:mm'
                ])
                ->add('cantidad', NumberType::class, ['label' => 'Cada cuántos minutos?'])
            ->end()
            ->with('Tramo Descanso', ['class' => 'col-md-4'])
                ->add('dIni', DateTimePickerType::class, [
                    'attr' => ['class'=>'col-md-6'],
                    'label' => 'Descanso Hora Inicio',
                    'dp_pick_date' => false,
                    'format' => 'HH:mm'
                ])
                ->add('dFin', DateTimePickerType::class, [
                    'label' => 'Descanso Hora Fin',
                    'dp_pick_date' => false,
                    'format' => 'HH:mm'
                ])
            ->end()
            ;
    }

    public function postPersist($object) {

        $incongruencias = false;
        // Comprobar incongruencias
        if ($incongruencias){
            // Existen incongruencias -> Elimina esta FechaCuadrante

            $container = $this->getConfigurationPool()->getContainer();
            $entityManager = $container->get('doctrine')->getManager();

            $entityManager->remove($object);
            $entityManager->flush();
            $this->getRequest()->getSession()->getFlashBag()->clear();
            $this->getRequest()->getSession()->getFlashBag()->add("danger", 'No se han generado las citas para la fecha '.$object->getFecha()->format('d-M-Y').', debido a un error en el formulario!');


        } else {
            // Genera Citas

            $cuadrante = $object->getCuadrante();
            $hIni = $object->getHIni();
            $hFin = $object->getHFin();
            $dIni = $object->getDIni();
            $dFin = $object->getDFin();
            $cantidad = $object->getCantidad(); // Cada cuantos minutos

            $tiempo = $hIni->diff($hFin);

            // Crear Cita en hora inicio, aumentar cantidad,
            // parar en hora inicio descanso,
            // continuar en hora fin descanso
            // y finalmente detener en hora fin

            $container = $this->getConfigurationPool()->getContainer();
            $entityManager = $container->get('doctrine')->getManager();
            $hFin->modify('-'.$cantidad.' minute');
            $genera = true;
            while ($genera) {
                // Create cita
                $cita = new CitasFechaCuadranteGrupoCarrera();
                $cita->setFechaCuadrante($object);
                $cita->setHora($hIni);

                $entityManager->persist($cita);
                $entityManager->flush();

                // Aumentar cantidad minutos
                $hIni->modify('+'.$cantidad.' minute');
                // Comprueba si pasa hora inicio Descanso

                if (($hIni>$dIni) && ($hIni<$dFin)){
                    // Tiempo de descanso
                    $hIni = $dFin;
                }
                if ($hIni>$hFin){
                    $genera = false;
                }
            }
        }


    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('fecha', 'date', ['format' => 'd-M-Y'])
            ;
    }
}
