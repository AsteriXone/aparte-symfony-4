<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotacionesProfesorCarreraRepository")
 */
class VotacionesProfesorCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCarrera", inversedBy="votacionesProfesorCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProfesorCarrera", inversedBy="votacionesProfesorCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profesor_carrera;

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

    public function getProfesorCarrera(): ?ProfesorCarrera
    {
        return $this->profesor_carrera;
    }

    public function setProfesorCarrera(?ProfesorCarrera $profesor_carrera): self
    {
        $this->profesor_carrera = $profesor_carrera;

        return $this;
    }
}
