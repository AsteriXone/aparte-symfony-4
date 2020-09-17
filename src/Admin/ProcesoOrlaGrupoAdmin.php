<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;


final class ProcesoOrlaGrupoAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

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

            ->add('estado')
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
            ->add('grupoCarrera', null, [
                'label'=>'Grupo',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'codigo_grupo'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'grupo_carrera'))
            ])
            ->add('estado', null,[
                'template' => 'grupos-carrera/estado_orla_list_admin.html.twig',
                'label' => 'Estado Orla'
            ])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            // ->add('id')
            ->add('grupo_carrera', null, ['disabled' => true])
            ->add('estado', ChoiceType::class, [
                'label' => 'Estado Orla',
                'choices' => [
                    'Sesión de fotos activa' => 'sesion',
                    'Nombrado de fotografía' => 'nombrado',
                    'Retoque' => 'retoque',
                    'Montaje' => 'montaje',
                    'Corrección' => 'correccion',
                    'Fin de Corrección' => 'fin_correccion',
                    'Entregada' => 'entregada',
                ]
            ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('estado')
            ;
    }
}
