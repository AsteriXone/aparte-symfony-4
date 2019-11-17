<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use App\Entity\GrupoCarrera;

final class CuadrantesGruposCarreraAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            ->add('cuadrante')
            ->add('grupo_carrera', null, ['label' => 'Grupo'], null, [
                'query_builder' => function (EntityRepository $er) {
                        $container = $this->getConfigurationPool()->getContainer();
                        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

                        return $er->createQueryBuilder('u')
                        ->where('u.userAdmin = :user_admin')
                        ->setParameter('user_admin', $user_admin);
                    }
            ])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('cuadrante')
            ->add('grupo_carrera')
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
            ->add('cuadrante', ModelListType::class, [
            'btn_add' => 'Crear nuevo',
            'btn_list' => 'Listado',
            'btn_delete' => false,
            'btn_edit' => false,
            // 'route' => ['name'=>'']
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
            ->add('cuadrante')
            ->add('grupo_carrera')
            ;
    }
}
