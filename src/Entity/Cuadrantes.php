<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CuadrantesRepository")
 */
class Cuadrantes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre_cuadrante;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CuadrantesGruposCarrera", mappedBy="cuadrante", orphanRemoval=true)
     */
    private $cuadrantesGruposCarreras;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FechaCuadranteGrupoCarrera", mappedBy="cuadrante", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $fechasCuadranteCarrera;

    public function __construct()
    {
        $this->cuadrantesGruposCarreras = new ArrayCollection();
        $this->fechasCuadranteCarrera = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre_cuadrante;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCuadrante(): ?string
    {
        return $this->nombre_cuadrante;
    }

    public function setNombreCuadrante(string $nombre_cuadrante): self
    {
        $this->nombre_cuadrante = $nombre_cuadrante;

        return $this;
    }

    /**
     * @return Collection|CuadrantesGruposCarrera[]
     */
    public function getCuadrantesGruposCarreras(): Collection
    {
        return $this->cuadrantesGruposCarreras;
    }

    public function addCuadrantesGruposCarrera(CuadrantesGruposCarrera $cuadrantesGruposCarrera): self
    {
        if (!$this->cuadrantesGruposCarreras->contains($cuadrantesGruposCarrera)) {
            $this->cuadrantesGruposCarreras[] = $cuadrantesGruposCarrera;
            $cuadrantesGruposCarrera->setCuadrante($this);
        }

        return $this;
    }

    public function removeCuadrantesGruposCarrera(CuadrantesGruposCarrera $cuadrantesGruposCarrera): self
    {
        if ($this->cuadrantesGruposCarreras->contains($cuadrantesGruposCarrera)) {
            $this->cuadrantesGruposCarreras->removeElement($cuadrantesGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($cuadrantesGruposCarrera->getCuadrante() === $this) {
                $cuadrantesGruposCarrera->setCuadrante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FechaCuadranteGrupoCarrera[]
     */
    public function getFechasCuadranteCarrera(): Collection
    {
        return $this->fechasCuadranteCarrera;
    }

    public function addFechasCuadranteCarrera(FechaCuadranteGrupoCarrera $fechasCuadranteCarrera): self
    {
        if (!$this->fechasCuadranteCarrera->contains($fechasCuadranteCarrera)) {
            $this->fechasCuadranteCarrera[] = $fechasCuadranteCarrera;
            $fechasCuadranteCarrera->setCuadrante($this);
        }

        return $this;
    }

    public function removeFechasCuadranteCarrera(FechaCuadranteGrupoCarrera $fechasCuadranteCarrera): self
    {
        if ($this->fechasCuadranteCarrera->contains($fechasCuadranteCarrera)) {
            $this->fechasCuadranteCarrera->removeElement($fechasCuadranteCarrera);
            // set the owning side to null (unless already changed)
            if ($fechasCuadranteCarrera->getCuadrante() === $this) {
                $fechasCuadranteCarrera->setCuadrante(null);
            }
        }

        return $this;
    }
}
