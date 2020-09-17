<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcesoOrlaGrupoRepository")
 */
class ProcesoOrlaGrupo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $estado;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="procesoOrlaGrupo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $fecha_entrega;

    public function __toString()
    {
        // TODO: Return String Data Carrera (Universidad-Especialidad)
        return 'Proceso orla grupo '.$this->getGrupoCarrera()->getCodigoGrupo() ?: '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getGrupoCarrera(): ?GrupoCarrera
    {
        return $this->grupo_carrera;
    }

    public function setGrupoCarrera(GrupoCarrera $grupo_carrera): self
    {
        $this->grupo_carrera = $grupo_carrera;

        return $this;
    }

    public function getFechaEntrega(): ?\DateTimeInterface
    {
        return $this->fecha_entrega;
    }

    public function setFechaEntrega(?\DateTimeInterface $fecha_entrega): self
    {
        $this->fecha_entrega = $fecha_entrega;

        return $this;
    }
}
