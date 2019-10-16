<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Form\Type\ModelListType;
use Vich\UploaderBundle\Form\Type\VichFileType;

final class GrupoCarreraAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'carrera';
    protected $baseRoutePattern = 'carrera';

    protected $datagridValues = [

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'DESC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'id',
    ];


    public function createQuery($context = 'list')
    {
        // This query shows only the user GrupoCarrera owner

        // Getting useAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();

        // Query
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0].'.userAdmin', ':param')
        );
        $query->setParameter('param', $user_admin);

        return $query;
    }

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Carrera";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // ->add('id')
            ->add('codigo_grupo', null, ['label' => 'Código Grupo'])
            ->add('universidad', null, ['label' => 'Universidad'])
            ->add('especialidadCarrera', null, ['label' => 'Especialidad'])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('universidad', null, [
                'route' => ['name'=>''],
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'Nombre'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'universidad'))
            ])
            ->add('especialidadCarrera', null, [
                'label' => 'Especialidad',
                'route' => ['name'=>''],
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'especialidad'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'especialidadCarrera'))
            ])
            ->add('codigo_grupo', null, ['label' => 'Código Grupo', 'editable' => true])
            ->add('isActive', null, ['label' => 'Activo', 'editable' => true])
            ->add('isCitasActive', null, ['label' => 'Citas', 'editable' => true])
            ->add('isVotacionesActive', null, ['label' => 'Votaciones', 'editable' => true])
            ->add('isContratoActive', null, ['label' => 'Contrato', 'editable' => true])
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
        // 'btn_edit' => false,
        if ($this->isCurrentRoute('edit')){
            // EDIT
            $formMapper
                ->with('Carrera', ['class'=> 'col-md-8'])
                    ->add('universidad', ModelListType::class, [
                        // 'property'=>'Nombre',
                        // 'dropdown_auto_width' => true,
                        'btn_add' => false,
                        'btn_list' => 'Listado',
                        'btn_delete' => false,
                        'btn_edit' => false,
                    ])
                    ->add('especialidadCarrera', ModelListType::class, [
                        'label' => 'Especialidad',
                        'btn_add' => false,
                        'btn_list' => 'Listado',
                        'btn_delete' => false,
                        'btn_edit' => false,
                    ])
                    ->add('codigo_grupo')
                ->end()
                ->with('Estado', ['class'=> 'col-md-4'])
                    ->add('isActive', null, ['label' => 'Activo'])
                    ->add('isCitasActive', null, ['label' => 'Citas'])
                    ->add('isVotacionesActive', null, ['label' => 'Votaciones'])
                    ->add('isContratoActive', null, ['label' => 'Contrato'])
                    ->add('numeroMaximoVotarProfes', null, ['label' => '¿A cuántos profes se puede votar?'])
                    ->add('numeroMaximoVotarOrlas', null, ['label' => '¿Cuántas orlas se puede votar?'])
                ->end()
                ->with('Contrato', ['class'=> 'col-md-12'])
                    ->add('contratoFile', VichFileType::class, [
                        'label' => 'Contrato PDF',
                        'required' => false,
                    ])
                ->end()

                ;
        } else {
            // CREATE
            // dump('create');
            $formMapper
                ->with('Carrera', ['class'=> 'col-md-8'])
                    ->add('universidad', ModelListType::class, [
                        // 'property'=>'Nombre',
                        // 'dropdown_auto_width' => true,
                        'btn_add' => 'Añadir Nueva',
                        'btn_list' => 'Listado',
                        'btn_delete' => false,
                        'btn_edit' => false,
                    ])
                    ->add('especialidadCarrera', ModelListType::class, [
                        'label' => 'Especialidad',
                        'btn_add' => 'Añadir Nueva',
                        'btn_list' => 'Listado',
                        'btn_delete' => false,
                        'btn_edit' => false,
                    ])
                    ->add('codigo_grupo')
                ->end()
                ->with('Estado', ['class'=> 'col-md-4'])
                    ->add('isActive', null, ['label' => 'Activo'])
                    ->add('isCitasActive', null, ['label' => 'Citas'])
                    ->add('isVotacionesActive', null, ['label' => 'Votaciones'])
                    ->add('isContratoActive', null, ['label' => 'Contrato'])
                    ->add('numeroMaximoVotarProfes', null, ['label' => '¿A cuántos profes se puede votar?', 'data'=> 5])
                    ->add('numeroMaximoVotarOrlas', null, ['label' => '¿Cuántas orlas se puede votar?', 'data'=> 2])
                ->end()
                ->with('Contrato', ['class'=> 'col-md-12'])
                    ->add('contratoFile', VichFileType::class, [
                        'label' => 'Contrato PDF',
                        'required' => false,
                    ])
                ->end()
                ;
        }

    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('codigo_grupo')
            ->add('isActive')
            ->add('isCitasActive')
            ->add('isVotacionesActive')
            ->add('isContratoActive')
            ->add('usersCarrera', null, ['label'=>'Usuarios','admin_code' => 'admin.user_carrera'])
            // ->add('usersCarrera', null, ['label'=>'Usuarios','admin_code' => 'admin.user_carrera', 'route' => [
            //     'name' => ''
            // ]])
            ;
    }

    public function prePersist($object) {
        // setUserAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
        $object->setUserAdmin($admin);
    }
}
