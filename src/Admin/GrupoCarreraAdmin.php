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
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Entity\ProcesoOrlaGrupo;
use App\Entity\UserCarrera;


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
            ->add('procesoOrlaGrupo.estado', null,
            [
                'calegula' => false,
                'template' => 'grupos-carrera/estado_orla_list_admin_grupo.html.twig',

                // 'choices' => ['uno'=>'uno', 'dos'=>'dos'],
                'label' => 'Estado Orla',
                'editable'=> true
            ])
            // ->add('procesoOrlaGrupo.estado',null ,[
            //     'template' => 'grupos-carrera/estado_orla_list_admin_grupo.html.twig',
            //     'label' => 'Estado Orla',
            //     'editable'=> true
            // ])
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
                    ->add('numeroMaximoVotarProfes', null, ['label' => '¿A cuántos profes se puede votar?', 'data'=> 5])
                    ->add('numeroMaximoVotarOrlas', null, ['label' => '¿Cuántas orlas se puede votar?', 'data'=> 2])
                    ->add('numeroMaximoVotarColorBecas', null, ['label' => '¿Cuántos colores de beca se puede votar?', 'data'=> 1])
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
                    ->add('numeroMaximoVotarColorBecas', null, ['label' => '¿Cuántos colores de beca se puede votar?', 'data'=> 1])
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
        $object->setContrato('No tiene');
    }

    public function postPersist($object) {
        // Create user
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $container->get('doctrine')->getManager();

        $user = new User();
        $user->setNombre('Usuario');
        $user->setApellido1('Auto generado');
        $user->setTelefono('');
        $user->setMencion(false);
        $user->setIsErasmus(false);
        $user->setFechaRegistro(new \DateTime('now'));
        $email = $object->getCodigoGrupo().'@gmail.com';
        $user->setEmail($email);
        $user->setRoles(['ROLE_CARRERA', 'ROLE_USER']);

        $password = $object->getCodigoGrupo().'1.0';
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $password);
        $user->setPassword($encoded);
        // tell Doctrine you want to (eventually) save the UserAdmin (no queries yet)
        $entityManager->persist($user);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // Create userCarrera
        $userCarrera = new UserCarrera();
        $userCarrera->setUser($user);
        $userCarrera->setGrupoCarrera($object);
        // tell Doctrine you want to (eventually) save the UserAdmin (no queries yet)
        $entityManager->persist($userCarrera);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // Create userCarrera
        $procesoOrlaGrupo = new ProcesoOrlaGrupo();
        $procesoOrlaGrupo->setGrupoCarrera($object);
        $procesoOrlaGrupo->setEstado("Sin estado");
        // tell Doctrine you want to (eventually) save the UserAdmin (no queries yet)
        $entityManager->persist($procesoOrlaGrupo);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
    }
}
