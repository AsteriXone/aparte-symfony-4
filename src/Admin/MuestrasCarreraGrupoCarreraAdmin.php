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

final class MuestrasCarreraGrupoCarreraAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
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
            ->add('id')
            ->add('grupo_carrera', null, ['label'=>'Grupo'])
            ->add('muestras_carrera', null, ['label'=>'Muestra'])
            ->add('Imagen', null, ['template' => 'muestras/muestra_carrera_grupo_list_admin.html.twig',])
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
            ->add('muestras_carrera', ModelListType::class, [
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
            ;
    }
}
