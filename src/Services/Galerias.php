<?php
/**
 * Created by PhpStorm.
 * User: asterixone
 * Date: 04/10/2018
 * Time: 13:43
 */

namespace App\Services;

use App\Entity\Galeria;
use Doctrine\ORM\EntityManagerInterface;

class Galerias
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

    public function getGalerias()
    {
        // Traer galerias de DB
//        $entityManager = $this->em->getRepository(Galeria::class);
        $entityManager = $this->em->getRepository(Galeria::class);
        $galerias = $entityManager->findAll();
        // dump(galerias);
        if ($galerias){
            return $galerias;
        } else {
            return "No existen!";
        }

        return null;
    }
}
