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

final class UserAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'usuarios';
    protected $baseRoutePattern = 'usuarios';

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Usuarios";
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
            // Block
            // ->add('titulacion')
            // ->add('mencion')
            // ->add('isErasmus')
            ->add('roles', null, ['label'=>'Roles'])
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
            // BLock
            ->with('Registro', ['class' => 'col-md-6'])
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
            ->end()
            ->with('Datos', ['class' => 'col-md-6'])
                ->add('nombre')
                ->add('apellido_1')
                ->add('apellido_2')
                ->add('direccion')
            ->end()
            ->with('Datos académicos', ['class' => 'col-md-6'])
                // ->add('titulacion')
                ->add('mencion')
                ->add('isErasmus')
            ->end()
            ;
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

    public function prePersist($object) { // $object is an instance of App\Entity\User as specified in services.yaml
        // Encoding password
        $plainPassword = $object->getPassword();
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($object, $plainPassword);

        $object->setPassword($encoded);
    }
}
