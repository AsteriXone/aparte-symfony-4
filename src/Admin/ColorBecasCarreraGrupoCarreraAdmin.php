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

final class ColorBecasCarreraGrupoCarreraAdmin extends AbstractAdmin
{
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
            ->add('colorBecas_carrera')
            ;
    }

    public function createQuery($context = 'list')
    {
        // Getting useAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $idUserAdmin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
        $query = parent::createQuery($context);
        $query
        ->innerJoin($query->getRootAliases()[0].'.grupo_carrera', 'gc')
        ->innerJoin('gc.userAdmin', 'ua')
        ->andWhere('ua = :userAdmin');
        $query->setParameter('userAdmin', $idUserAdmin);
        return $query;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('grupo_carrera', null, [
                'label' => 'Grupo',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'codigo_grupo'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'grupo_carrera'))
            ])
            ->add('colorBecas_carrera', null, [
                'label'=>'ColorBecas',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'imageName'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'colorBecas_carrera'))
            ])
            ->add('Imagen', null, ['template' => 'colorBecas/colorBeca_carrera_grupo_list_admin.html.twig',])
            ->add('votos', null, [
                'class'=>'text-center',
                'label'=>'Nº de Votos',
                'template' => 'usuarios_carrera/numero_votos_colorBecas_admin.html.twig',
                'header_style' => 'text-align: center',
                'row_align' => 'center',
            ])
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
            ->add('colorBecas_carrera', ModelListType::class, [
                // 'property'=>'Nombre',
                // 'dropdown_auto_width' => true,
                'btn_add' => 'Añadir',
                'btn_list' => 'Listado',
                'btn_delete' => false,
                'btn_edit' => false,
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
            ->add('grupo_carrera', null, ['label' => 'Grupo'])
            ->add('colorBecas_carrera', null, ['label' => 'ColorBecas', 'route' => ['name'=>'']])
            ;
    }
}
