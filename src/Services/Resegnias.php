<?php
/**
 * Created by PhpStorm.
 * User: asterixone
 * Date: 04/10/2018
 * Time: 13:43
 */

namespace App\Services;

use App\Entity\Resegnia;
use Doctrine\ORM\EntityManagerInterface;

class Resegnias
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
//        dump($entityManager);
    }

    public function getResegnias()
    {
        // Traer resenias de DB
//        $entityManager = $this->em->getRepository(Galeria::class);
        $entityManager = $this->em->getRepository(Resegnia::class);
        $resegnias = $entityManager->findAll();
        // dump(galerias);
        if ($resegnias){
            return $resegnias;
        } else {
            return "No existen!";
        }

        return null;
    }
}
