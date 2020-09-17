<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

use Sonata\AdminBundle\Route\RouteCollection;

final class ResegniaAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
        // TODO
            ->add('id')
            // ->add('calidad_precio')
            // ->add('ambiente')
            // ->add('trato')
            // ->add('accesibilidad')
            // ->add('disegnio_opciones')
            // ->add('comentario')
            // ->add('publicada')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('userCarrera', null, [
                'label'=>'Usuario',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'user'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'user_carrera'))
            ])
            ->add('calidad_precio', null, ['label' => "Calidad"])
            ->add('ambiente')
            ->add('trato')
            ->add('accesibilidad')
            ->add('disegnio_opciones', null, ['label' => "Diseño"])
            ->add('fecha_publicacion', null, ['format' => 'd/m/Y', 'label'=> 'Publicación', 'sortable' => true,
            ])
            ->add('comentario')
            ->add('publicada', null, ['editable' => true])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            // ->add('id')
            ->add('calidad_precio', null, ['attr' => ['min'=>0, 'max' => 5]])
            ->add('ambiente', null, ['attr' => ['min'=>0, 'max' => 5]])
            ->add('trato', null, ['attr' => ['min'=>0, 'max' => 5]])
            ->add('accesibilidad', null, ['attr' => ['min'=>0, 'max' => 5]])
            ->add('disegnio_opciones', null, ['attr' => ['min'=>0, 'max' => 5]])
            ->add('fecha_publicacion', DatePickerType::class, ['format' => 'dd-MMMM-yyyy'])
            ->add('comentario')
            ->add('publicada')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            // ->add('id')
            ->add('calidad_precio')
            ->add('ambiente')
            ->add('trato')
            ->add('accesibilidad')
            ->add('disegnio_opciones')
            ->add('fecha_publicacion', null, ['label'=> 'Fecha', 'format' => 'd-M-Y'])
            ->add('comentario')
            ->add('publicada')
            ;
    }
}
