<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Route\RouteCollection;

final class CitasFechaCuadranteGrupoCarreraAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            ->add('fechaCuadrante', null, ['label'=> 'Fechas'])
            ->add('fechaCuadrante.cuadrante', null, ['label'=> 'Cuadrantes'])
            // ->add('fechaCuadrante.fecha', null, ['label'=> 'Fecha', 'format' => 'd-M-Y'])
            ->add('usuario', null, ['label'=> 'Usuario'])
            // ->add('usuario.grupoCarrera', null, ['label'=> 'Grupo'])
            ->add('usuario.user.email', null, ['label'=> 'Correo'])
            ->add('usuario.user.telefono', null, ['label'=> 'Telefono'])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            // ->add('fechaCuadrante.cuadrante', null, ['label'=> 'Cuadrante'])
            ->add('fechaCuadrante.cuadrante', null, [
                'route'=>['name'=>''],
                'label'=>'Cuadrante',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'cuadrante'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'fechaCuadrante'))
            ])
            ->add('fechaCuadrante.fecha', null, ['label'=> 'Fecha', 'format' => 'd-M-Y'])
            ->add('hora')
            ->add('usuario', null, ['label'=> 'Usuario'])
            ->add('usuario.grupoCarrera', null, ['label'=> 'Grupo'])
            ->add('usuario.user.email', null, ['label'=> 'Correo'])
            ->add('usuario.user.telefono', null, ['label'=> 'Telefono'])
            // ->add('_action', null, [
            //     'actions' => [
            //         'show' => null,
            //         'edit' => null,
            //         'delete' => null,
            //     ],
            // ])
            ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            // ->add('id')
            ->add('hora')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('hora')
            ;
    }


    public function getExportFields(){

        return array(
            'Cuadrante' => 'fechaCuadrante.cuadrante',
            'Fecha' => 'fechaCuadrante.onlyFecha',
            'Usuario'=> 'usuario.user.nombreCompleto',
            'Grupo' => 'usuario.grupoCarrera',
            'Correo'=>'usuario.user.email',
            'Telefono' => 'usuario.user.telefono',
            'Hora' => 'onlyHora',
        );
    }
}
