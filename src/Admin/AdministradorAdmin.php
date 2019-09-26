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
use App\Entity\UserAdmin;
use Doctrine\ORM\EntityManagerInterface;


final class AdministradorAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'administradores';
    protected $baseRoutePattern = 'administradores';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->like($query->getRootAliases()[0].'.roles', ':param')
        );
        $query->setParameter('param', '%ROLE_ADMIN%');
        return $query;
    }

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Administradores";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('email')
            // ->add('roles')
            ->add('password')
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
            ->add('userAdmin.gruposCarrera', null , ['route' => [
                    'name' => ''
                ]])
            // ->add('roles', 'array')
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
            // ->add('mencion')
            // ->add('isErasmus')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            // ->add('id')
            ->add('email')
            // ->add('roles')
            // ->add('password')
            ->add('userAdmin.gruposCarrera',null, [
                'label'=>'Grupos que administra',
                'route' => [
                    'name' => ''
                ]
            ]);
    }

    public function prePersist($object) { // $object is an instance of App\Entity\User as specified in services.yaml
        // Encoding password
        $plainPassword = $object->getPassword();
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($object, $plainPassword);

        $object->setPassword($encoded);

        // Set ROLE_ADMIN to User when save AdministradorAdmin
        $object->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $object->setIsErasmus(false);
        $object->setMencion(false);
    }
    public function postPersist($object) { // $object is an instance of App\Entity\User as specified in services.yaml
        // Save UserAdmin entity whith current user_id
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $container->get('doctrine')->getManager();

        $userAdmin = new UserAdmin();
        $userAdmin->setUser($object);

        // tell Doctrine you want to (eventually) save the UserAdmin (no queries yet)
        $entityManager->persist($userAdmin);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
    }
}
