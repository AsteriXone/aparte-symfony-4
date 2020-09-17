<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\GrupoCarrera;
use App\Entity\UserCarrera;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;

final class UserCarreraBaseAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'usuarios-carrera-base';
    protected $baseRoutePattern = 'usuarios-carrera-base';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    // Consulta que muestra solo usuarios de admin
    public function createQuery($context = 'list')
    {
        // Getting useAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $idUserAdmin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
        $query = parent::createQuery($context);
        $query
        ->innerJoin($query->getRootAliases()[0].'.userCarrera', 'uc')
        ->innerJoin('uc.grupo_carrera', 'gc')
        ->andWhere('gc.userAdmin = :userAdmin');
        // ->andWhere( // Podria omitirse
        //     $query->expr()->like($query->getRootAliases()[0].'.roles', ':param')
        // );
        // $query->setParameter('param', '%ROLE_CARRERA%'); // Podria omitirse
        $query->setParameter('userAdmin', $idUserAdmin);
        return $query;
    }

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Usuarios Carrera Base";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('email')
            // ->add('roles')
            ->add('password')
            ->add('userCarrera.grupo_carrera', null, []) // TODO: Muestra grupos pertenecientes al administrador
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('email')
            ->add('nombre')
            ->add('apellido_1')
            ->add('apellido_2')
            ->add('direccion')
            // Block
            // ->add('titulacion')
            ->add('mencion')
            ->add('isErasmus', null, ['label'=>'Erasmus'])
            // ->add('isVotarCitasActive')

            // ->add('roles', 'array')
            ->add('userCarrera.grupoCarrera', null, ['label'=>'Grupo'])
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
        if ($this->isCurrentRoute('edit', 'admin.user_carrera')){
            // EDIT
            $formMapper
                // BLock
                // ->add('id')
                ->add('email')
                ->add('telefono')
                // ->add('roles')

                // Block
                ->add('nombre')
                ->add('apellido_1')
                ->add('apellido_2')
                ->add('direccion')
                // Block
                // ->add('titulacion')
                ->add('mencion')
                ->add('isErasmus', null, ['label'=>'Erasmus'])
                ;
        } else {
            // CREATE
            $formMapper
                // BLock
                // ->add('id')
                ->add('email')
                ->add('telefono')
                // ->add('roles')
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Contraseña'),
                    'second_options' => array('label' => 'Repite contraseña'),
                    'invalid_message' => 'Las contraseñas no coinciden o son demasiado cortas (mínimo %num% carácteres)',
                    'invalid_message_parameters' => ['%num%' => 6],
                ))
                // Block
                ->add('nombre')
                ->add('apellido_1')
                ->add('apellido_2')
                ->add('direccion')
                // Block
                // ->add('titulacion')
                ->add('mencion')
                ->add('isErasmus', null, ['label'=>'Erasmus'])
                ;
        }

    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('email')
            ->add('roles')
            // ->add('password')
            ;
    }

    // public function prePersist($object) { // $object is an instance of App\Entity\User as specified in services.yaml
    //     // Encoding password
    //     $plainPassword = $object->getPassword();
    //     $container = $this->getConfigurationPool()->getContainer();
    //     $encoder = $container->get('security.password_encoder');
    //     $encoded = $encoder->encodePassword($object, $plainPassword);
    //
    //     $object->setPassword($encoded);
    //
    //     // Set ROLE_CARRERA to User when save UserCarreraAdmin
    //     $object->setRoles(['ROLE_CARRERA', 'ROLE_USER']);
    // }
    //
    // public function postPersist($object) { // $object is an instance of App\Entity\User as specified in services.yaml
    //     // Save UserAdmin entity whith current user_id
    //     $container = $this->getConfigurationPool()->getContainer();
    //     $entityManager = $container->get('doctrine')->getManager();
    //
    //     $uniqid = $this->getRequest()->query->get('uniqid');
    //     $formData = $this->getRequest()->request->get($uniqid);
    //     $grupoCarrera_id = $formData['grupo'];
    //     $grupoCarrera = $entityManager->getRepository(GrupoCarrera::class)->find($grupoCarrera_id);
    //
    //     $userCarrera = new UserCarrera();
    //     $userCarrera->setUser($object);
    //     $userCarrera->setGrupoCarrera($grupoCarrera);
    //
    //     // tell Doctrine you want to (eventually) save the UserCarrera (no queries yet)
    //     $entityManager->persist($userCarrera);
    //
    //     // actually executes the queries (i.e. the INSERT query)
    //     $entityManager->flush();
    // }
}
