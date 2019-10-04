<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Sonata\AdminBundle\Form\Type\ModelType;

use Doctrine\ORM\EntityRepository;

final class ImageGalleryAcademicaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'Imágenes Galería Académica';
    protected $baseRoutePattern = 'imagenes-galeria-academica';

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Imágenes Galería Académica";
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query
        ->innerJoin($query->getRootAliases()[0].'.galeria', 'g')
        ->andWhere(
            $query->expr()->like('g.tipo_galleria', ':param')
        );
        $query->setParameter('param', 'Académica');
        return $query;
    }

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
            ->add('galeria')
            ->add('imageName')
            ->add('updateAt')
            ->add('Imagen', null, ['template' => 'galerias/gallery_image_list_admin.html.twig',])
            ->add('_action', null, [
                'actions' => [
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            // ->add('id')
            ->add('galeria', null, [ 'label' => 'Galerías disponibles',
            'expanded' => true,
            'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                    ->where('g.tipo_galleria = :param')
                    ->setParameter('param', 'Academica');
                },
                // 'property'=>'Nombre',
                // 'dropdown_auto_width' => true,
                // 'btn_add' => false,
                // 'btn_list' => 'Listado',
                // 'btn_delete' => false,
                // 'btn_edit' => false,
            ])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
            ])
            // ->add('imageName')
            ->add('updateAt')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('imageName')
            ->add('updateAt')
            ;
    }
}
