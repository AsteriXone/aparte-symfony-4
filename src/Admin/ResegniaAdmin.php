<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ResegniaAdmin extends AbstractAdmin
{

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
            ->add('calidad_precio')
            ->add('ambiente')
            ->add('trato')
            ->add('accesibilidad')
            ->add('disegnio_opciones')
            ->add('comentario')
            ->add('publicada')
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
            ->add('id')
            ->add('calidad_precio')
            ->add('ambiente')
            ->add('trato')
            ->add('accesibilidad')
            ->add('disegnio_opciones')
            ->add('comentario')
            ->add('publicada')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('calidad_precio')
            ->add('ambiente')
            ->add('trato')
            ->add('accesibilidad')
            ->add('disegnio_opciones')
            ->add('comentario')
            ->add('publicada')
            ;
    }
}
