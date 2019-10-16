<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotacionesMuestraCarreraRepository")
 */
class VotacionesMuestraCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCarrera", inversedBy="votacionesMuestraCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MuestrasCarrera", inversedBy="votacionesMuestraCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $muestra_carrera;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCarrera(): ?UserCarrera
    {
        return $this->user_carrera;
    }

    public function setUserCarrera(?UserCarrera $user_carrera): self
    {
        $this->user_carrera = $user_carrera;

        return $this;
    }

    public function getMuestraCarrera(): ?MuestrasCarrera
    {
        return $this->muestra_carrera;
    }

    public function setMuestraCarrera(?MuestrasCarrera $muestra_carrera): self
    {
        $this->muestra_carrera = $muestra_carrera;

        return $this;
    }
}
