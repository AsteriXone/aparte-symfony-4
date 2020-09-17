<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniversidadRepository")
 */
class Universidad
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
    private $Nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GrupoCarrera", mappedBy="universidad", orphanRemoval=true)
     */
    private $grupo_carrera;

    public function __construct()
    {
        $this->grupo_carrera = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->Nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

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
            $grupoCarrera->setUniversidad($this);
        }

        return $this;
    }

    public function removeGrupoCarrera(GrupoCarrera $grupoCarrera): self
    {
        if ($this->grupo_carrera->contains($grupoCarrera)) {
            $this->grupo_carrera->removeElement($grupoCarrera);
            // set the owning side to null (unless already changed)
            if ($grupoCarrera->getUniversidad() === $this) {
                $grupoCarrera->setUniversidad(null);
            }
        }

        return $this;
    }
}
