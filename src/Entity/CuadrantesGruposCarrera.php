<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CuadrantesGruposCarreraRepository")
 */
class CuadrantesGruposCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cuadrantes", inversedBy="cuadrantesGruposCarreras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cuadrante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="cuadrantesGruposCarreras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuadrante(): ?Cuadrantes
    {
        return $this->cuadrante;
    }

    public function setCuadrante(?Cuadrantes $cuadrante): self
    {
        $this->cuadrante = $cuadrante;

        return $this;
    }

    public function getGrupoCarrera(): ?GrupoCarrera
    {
        return $this->grupo_carrera;
    }

    public function setGrupoCarrera(?GrupoCarrera $grupo_carrera): self
    {
        $this->grupo_carrera = $grupo_carrera;

        return $this;
    }
}
