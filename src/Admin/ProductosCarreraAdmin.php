<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichFileType;

final class ProductosCarreraAdmin extends AbstractAdmin
{
    // TODO: Mostrar solo muestras del Admin

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            // TODO: producto_carrera_list_admin.html.twig
            ->add('Imagen', null, ['template' => 'productos/producto_carrera_list_admin.html.twig',])
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
            // ->add('imageName')
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
            ])
            // ->add('imageName')
            ->add('updateAt')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            ;
    }
}
