<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidenciasCarreraRepository")
 */
class IncidenciasCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $incidencia;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCarrera", inversedBy="incidenciasCarreras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_carrera;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIncidencia(): ?string
    {
        return $this->incidencia;
    }

    public function setIncidencia(?string $incidencia): self
    {
        $this->incidencia = $incidencia;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
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
}
