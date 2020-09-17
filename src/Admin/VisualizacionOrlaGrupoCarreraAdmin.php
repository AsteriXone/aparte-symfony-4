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

final class VisualizacionOrlaGrupoCarreraAdmin extends AbstractAdmin
{
    public function createQuery($context = 'list')
    {
        // Getting useAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $idUserAdmin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
        $query = parent::createQuery($context);
        $query
        ->innerJoin($query->getRootAliases()[0].'.userCarrera', 'uc')
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
            ->add('userCarrera.grupo_carrera', null, ['label' => 'Grupo'], null, [
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->where('u.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    }
            ])
            ->add('userCarrera', null, ['label' => 'Usuario'], null, [
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->innerJoin('u.grupo_carrera', 'gc')
                        ->where('gc.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    }
            ])
            ->add('fechaVisualizacion', null, ['label'=>'Fecha Visualización'])

            // ->add('user_carrera', null, [
            //     'label'=>'Usuario',
            // ])
            ;
    }


    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('userCarrera.grupo_carrera', null, [
                'label' => 'Grupo',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'grupo_carrera'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'user_carrera'))

            ])
            ->add('userCarrera', null, [
                'label'=>'Usuario',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'user'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'user_carrera'))
            ])
            // ->add('orlaProvisionalGrupoCarrera.imageName')
            ->add('orlaProvisionalGrupoCarrera.imageName', null, ['label'=>'Nombre imagen'])
            ->add('orlaProvisionalGrupoCarrera.Imagen', null, ['label'=>'Imagen', 'template' => 'muestras/visualizacion_orla_provisional_carrera_list_admin.html.twig',])

            ->add('fechaVisualizacion', null, ['label'=> 'Fecha visualización', 'format' => 'd-M-Y'])
            ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            // ->add('id')
            ->add('fechaVisualizacion')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('fechaVisualizacion')
            ;
    }

    public function getExportFields(){

        return array(
            'Grupo' => 'userCarrera.grupo_carrera',
            'Nombre Orla' => 'orlaProvisionalGrupoCarrera.imageName',
            'Usuario' => 'userCarrera.user.nombreCompleto',
            'Email'=> 'userCarrera.user.email',
            'Fecha Visualizacion'=>'onlyDate',
        );
    }
}
