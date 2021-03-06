<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class GaleriaAdmin extends AbstractAdmin
{
    protected $datagridValues = [

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'ASC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'tipo_galleria',
    ];

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            ->add('nombre_galeria')
            // ->add('carpeta')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('tipo_galleria')
            ->add('nombre_galeria')
            // ->add('carpeta')
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
            ->add('tipo_galleria', ChoiceType::class, [
                'expanded' => true,
                'choices' => [
                    'Academica' => 'Académica',
                    'Social' => 'Social',
                ],
            ])
            ->add('nombre_galeria')
            // ->add('carpeta')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('nombre_galeria')
            // ->add('carpeta')
            ;
    }
}
