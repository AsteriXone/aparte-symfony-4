<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EspecialidadCarreraRepository")
 */
class EspecialidadCarrera
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
    private $especialidad;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GrupoCarrera", mappedBy="especialidadCarrera", orphanRemoval=true)
     */
    private $grupo_carrera;

    public function __construct()
    {
        $this->grupo_carrera = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->especialidad;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspecialidad(): ?string
    {
        return $this->especialidad;
    }

    public function setEspecialidad(string $especialidad): self
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    /**
     * @return Collection|GrupoCarrera[]
     */
    public function getGrupoCarrera(): Collection
    {
        return $this->grupo_carrera;
    }

    public function addGrupoCarrera(GrupoCarrera $grupoCarrera): self
    {
        if (!$this->grupo_carrera->contains($grupoCarrera)) {
            $this->grupo_carrera[] = $grupoCarrera;
            $grupoCarrera->setEspecialidadCarrera($this);
        }

        return $this;
    }

    public function removeGrupoCarrera(GrupoCarrera $grupoCarrera): self
    {
        if ($this->grupo_carrera->contains($grupoCarrera)) {
            $this->grupo_carrera->removeElement($grupoCarrera);
            // set the owning side to null (unless already changed)
            if ($grupoCarrera->getEspecialidadCarrera() === $this) {
                $grupoCarrera->setEspecialidadCarrera(null);
            }
        }

        return $this;
    }
}
