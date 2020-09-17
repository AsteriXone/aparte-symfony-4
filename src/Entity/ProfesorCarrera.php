<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesorCarreraRepository")
 */
class ProfesorCarrera
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
    private $nombre_completo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfesorGrupoCarrera", mappedBy="profesor_carrera", orphanRemoval=true)
     */
    private $profesorGruposCarrera;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $cargo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesProfesorCarrera", mappedBy="profesor_carrera", orphanRemoval=true)
     */
    private $votacionesProfesorCarrera;

    /**
     * Not mapped field to use in votacionesProfesorCarrera
     */
    private $isVotado = false;

    public function __construct()
    {
        $this->profesorGruposCarrera = new ArrayCollection();
        $this->votacionesProfesorCarrera = new ArrayCollection();
    }

    public function __toString(){
        return $this->nombre_completo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCompleto(): ?string
    {
        return $this->nombre_completo;
    }

    public function setNombreCompleto(string $nombre_completo): self
    {
        $this->nombre_completo = $nombre_completo;

        return $this;
    }

    /**
     * @return Collection|ProfesorGrupoCarrera[]
     */
    public function getProfesorGruposCarrera(): Collection
    {
        return $this->profesorGruposCarrera;
    }

    public function addProfesorGruposCarrera(ProfesorGrupoCarrera $profesorGruposCarrera): self
    {
        if (!$this->profesorGruposCarrera->contains($profesorGruposCarrera)) {
            $this->profesorGruposCarrera[] = $profesorGruposCarrera;
            $profesorGruposCarrera->setProfesorCarrera($this);
        }

        return $this;
    }

    public function removeProfesorGruposCarrera(ProfesorGrupoCarrera $profesorGruposCarrera): self
    {
        if ($this->profesorGruposCarrera->contains($profesorGruposCarrera)) {
            $this->profesorGruposCarrera->removeElement($profesorGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($profesorGruposCarrera->getProfesorCarrera() === $this) {
                $profesorGruposCarrera->setProfesorCarrera(null);
            }
        }

        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * @return Collection|VotacionesProfesorCarrera[]
     */
    public function getVotacionesProfesorCarrera(): Collection
    {
        return $this->votacionesProfesorCarrera;
    }

    public function addVotacionesProfesorCarrera(VotacionesProfesorCarrera $votacionesProfesorCarrera): self
    {
        if (!$this->votacionesProfesorCarrera->contains($votacionesProfesorCarrera)) {
            $this->votacionesProfesorCarrera[] = $votacionesProfesorCarrera;
            $votacionesProfesorCarrera->setProfesorCarrera($this);
        }

        return $this;
    }

    public function removeVotacionesProfesorCarrera(VotacionesProfesorCarrera $votacionesProfesorCarrera): self
    {
        if ($this->votacionesProfesorCarrera->contains($votacionesProfesorCarrera)) {
            $this->votacionesProfesorCarrera->removeElement($votacionesProfesorCarrera);
            // set the owning side to null (unless already changed)
            if ($votacionesProfesorCarrera->getProfesorCarrera() === $this) {
                $votacionesProfesorCarrera->setProfesorCarrera(null);
            }
        }

        return $this;
    }

    public function getIsVotado()
    {
        return $this->isVotado;
    }

    public function setIsVotado($opcion)
    {
        $this->isVotado = $opcion;

        return $this;
    }

}
