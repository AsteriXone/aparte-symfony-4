<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Form\Type\ModelListType;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;

final class ProfesorGrupoCarreraAdmin extends AbstractAdmin
{
    // protected function configureRoutes(RouteCollection $collection)
    // {
    //     $collection->remove('delete');
    // }

    protected $datagridValues = [

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'ASC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'grupo_carrera',
    ];


    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            ->add('grupo_carrera', null, ['label' => 'Grupo'], null, [
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->where('u.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    }
            ])
            ->add('profesor_carrera')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('grupo_carrera', null, [
                'label' => 'Grupo Carrera',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'codigo_grupo'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'grupo_carrera'))
            ])
            ->add('profesor_carrera', null, [
                'label' => 'Profesor Carrera',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'nombre_completo'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'profesor_carrera'))
            ])
            ->add('votos', null, [
                'class'=>'text-center',
                'label'=>'Nº de Votos',
                'template' => 'usuarios_carrera/numero_votos_admin.html.twig',
                'header_style' => 'text-align: center',
                'row_align' => 'center',
            ])
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
            ->add('profesor_carrera', ModelListType::class, [
                'label' => 'Profesor Carrera',
                'btn_add' => 'Añadir Nuevo',
                'btn_list' => 'Listado',
                'btn_delete' => null,
                'btn_edit' => 'Editar',
            ])
            ->add('grupo_carrera', null, [
                'label' => 'Grupo',
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->where('u.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    },
            ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('profesor_carrera')
            ->add('grupo_carrera')
            ;
    }

    public function getExportFields(){
        return array(
            'Grupo' => 'grupo_carrera',
            'Profesor' => 'profesor_carrera',
            'Votos'=> 'votos',
        );
    }
}
