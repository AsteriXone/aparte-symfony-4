<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityRepository;



final class IncidenciasCarreraAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'incidencias-carrera';
    protected $baseRoutePattern = 'incidencias-carrera';

    public function createQuery($context = 'list')
    {
        // Getting useAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $idUserAdmin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
        $query = parent::createQuery($context);
        $query
        ->innerJoin($query->getRootAliases()[0].'.user_carrera', 'uc')
        ->innerJoin('uc.grupo_carrera', 'gc')
        ->innerJoin('gc.userAdmin', 'ua')
        ->andWhere('ua = :userAdmin');
        $query->setParameter('userAdmin', $idUserAdmin);
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            // ->add('incidencia')
            // ->add('descripcion')
            ->add('user_carrera.grupo_carrera', null, ['label' => 'Grupo'], null, [
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->where('u.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    }
            ])
            ->add('user_carrera', null, ['label' => 'Usuario'], null, [
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->innerJoin('u.grupo_carrera', 'gc')
                        ->where('gc.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    }
            ])
            // ->add('user_carrera', null, [
            //     'label'=>'Usuario',
            // ])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            // ->add('incidencia')
            // ->add('user_carrera.grupo_carrera', null, [
            //     'label' => 'Grupo'
            // ])
            ->add('user_carrera.grupo_carrera', null, [
                'label' => 'Grupo',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'grupo_carrera'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'user_carrera'))

            ])
            ->add('user_carrera', null, [
                'label'=>'Usuario',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'user'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'user_carrera'))
            ])
            ->add('incidencia')
            ->add('descripcion')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('id')
            ->add('incidencia')
            ->add('descripcion')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            // ->add('id')
            // ->add('incidencia')
            // ->add('descripcion')
            ->add('user_carrera.grupo_carrera', null, [
                'label' => 'Grupo', 'route' => ['name'=>'']
            ])
            ->add('user_carrera', null, [
                'label'=>'Usuario', 'route' => ['name'=>'']
            ])
            ->add('incidencia')
            ->add('descripcion')
            ;
    }
}
