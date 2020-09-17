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

use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

final class UserSocialAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'usuarios-social';
    protected $baseRoutePattern = 'usuarios-social';

    public function createQuery($context = 'list')
    {
        // Getting useAdmin
        $container = $this->getConfigurationPool()->getContainer();
        $idUserAdmin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
        $query = parent::createQuery($context);
        $query
        ->innerJoin($query->getRootAliases()[0].'.grupo_social', 'gs')
        ->innerJoin('gs.userAdmin', 'ua')
        ->andWhere('ua = :userAdmin');
        $query->setParameter('userAdmin', $idUserAdmin);
        return $query;
    }

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Usuarios Social";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            // TODO: Add User filters ->add('user.')
            ->add('grupo_social', null, ['label' => 'Grupo'], '', [ 'query_builder' => function (EntityRepository $er) {
                    $container = $this->getConfigurationPool()->getContainer();
                    $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
                    return $er->createQueryBuilder('u')
                    ->where('u.userAdmin = :user_admin')
                    ->setParameter('user_admin', $user_admin);
                },])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            // ->add('id')
            ->add('grupoSocial', null, [
                'label'=>'Grupo',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'codigo_grupo'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'grupo_social'))
            ])
            ->add('user.email', null, ['label'=>'Email'])
            ->add('user.nombreCompleto', null, [
                'label'=>'Usuario',
                'sortable' => true,
                'sort_field_mapping'=> array('fieldName'=>'nombre'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'user'))
            ])
            // ->add('user.apellido_1', null, ['label'=>'Apellido 1'])
            // ->add('user.apellido_2', null, ['label'=>'Apellido 2'])
            // ->add('user.direccion', null, ['label'=>'Dirección'])
            ->add('user.onlyDate', null, ['label'=>'Fecha Registro'])
            // ->add('isVotarCitasActive', null, ['label'=>'Bloqueado', 'editable' => true])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    // protected function configureFormFields(FormMapper $formMapper): void
    // {
    //     $formMapper
    //         // BLock
    //         // ->add('id')
    //         ->add('user', AdminType::class, ['label' => 'Usuario'] ,['admin_code' => 'admin.user_carrera_base'])
    //         ->add('isVotarCitasActive', null, ['label'=>'Bloqueado'])
    //         ->add('grupo_carrera', null, [
    //             'label' => 'Grupo',
    //             'query_builder' => function (EntityRepository $er) {
    //                     $container = $this->getConfigurationPool()->getContainer();
    //                     $user_admin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
    //
    //                     return $er->createQueryBuilder('u')
    //                     ->where('u.userAdmin = :user_admin')
    //                     ->setParameter('user_admin', $user_admin);
    //                 },
    //         ])
    //     ;
    // }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            // ->add('id')
            // ->add('email')
            // ->add('roles')
            // ->add('password')
            ;
    }

    // public function prePersist($object) { // $object is an instance of App\Entity\UserCarrera as specified in services.yaml
    //     // Encoding password
    //     $plainPassword = $object->getUser()->getPassword();
    //     $container = $this->getConfigurationPool()->getContainer();
    //     $encoder = $container->get('security.password_encoder');
    //     $encoded = $encoder->encodePassword($object->getUser(), $plainPassword);
    //
    //     $object->getUser()->setPassword($encoded);
    //
    //     // Set ROLE_CARRERA to User when save UserCarreraAdmin
    //     $object->getUser()->setRoles(['ROLE_CARRERA', 'ROLE_USER']);
    // }
    //
    // public function postRemove($object){
    //     // Elimina Usuario de tabla User
    //         $container = $this->getConfigurationPool()->getContainer();
    //         $entityManager = $container->get('doctrine')->getManager();
    //
    //         $user = $entityManager->getRepository(User::class)->find($object->getUser());
    //
    //         // tell Doctrine you want to (eventually) remove the User (no queries yet)
    //         $entityManager->remove($user);
    //
    //         // actually executes the queries (i.e. the INSERT query)
    //         $entityManager->flush();
    // }

    public function getExportFields(){

        return array(
            'Grupo' => 'grupoSocial',
            'Usuario' => 'user.nombreCompleto',
            'Email'=> 'user.email',
            'Teléfono' => 'user.telefono',
            'FechaRegistro'=>'user.onlyDate',
        );
    }
}
