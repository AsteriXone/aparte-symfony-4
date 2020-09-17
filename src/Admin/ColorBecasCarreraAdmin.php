<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichFileType;

final class ColorBecasCarreraAdmin extends AbstractAdmin
{
    // TODO: Mostrar solo colorBecas del Admin

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            ->add('Imagen', null, ['template' => 'colorBecas/colorBeca_carrera_list_admin.html.twig',])
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
            // ->add('imageName')
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
            ])
            // ->add('imageName')
            ->add('updateAt')
            ;
    }

    // public function prePersist($object) { // $object is an instance of App\Entity\UserCarrera as specified in services.yaml
    //     // Getting useAdmin
    //     // $container = $this->getConfigurationPool()->getContainer();
    //     // $userAdmin = $container->get('security.token_storage')->getToken()->getUser()->getUserAdmin();
    //     // $object->setUserAdmin($userAdmin);
    // }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            ;
    }
}
