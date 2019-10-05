<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrupoCarreraRepository")
 */
class GrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $codigo_grupo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCitasActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVotacionesActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAdmin", inversedBy="gruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAdmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $usersCarrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Universidad", inversedBy="grupo_carrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $universidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EspecialidadCarrera", inversedBy="grupo_carrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidadCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MuestrasCarreraGrupoCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $muestraCarreraGruposCarrera;

    public function __construct()
    {
        $this->usersCarrera = new ArrayCollection();
        $this->muestraCarreraGruposCarrera = new ArrayCollection();
    }

    public function __toString()
    {
        // TODO: Return String Data Carrera (Universidad-Especialidad)
        return $this->getCodigoGrupo() ?: '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoGrupo(): ?string
    {
        return $this->codigo_grupo;
    }

    public function setCodigoGrupo(?string $codigo_grupo): self
    {
        $this->codigo_grupo = $codigo_grupo;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsCitasActive(): ?bool
    {
        return $this->isCitasActive;
    }

    public function setIsCitasActive(bool $isCitasActive): self
    {
        $this->isCitasActive = $isCitasActive;

        return $this;
    }

    public function getIsVotacionesActive(): ?bool
    {
        return $this->isVotacionesActive;
    }

    public function setIsVotacionesActive(bool $isVotacionesActive): self
    {
        $this->isVotacionesActive = $isVotacionesActive;

        return $this;
    }

    public function getUserAdmin(): ?UserAdmin
    {
        return $this->userAdmin;
    }

    public function setUserAdmin(?UserAdmin $userAdmin): self
    {
        $this->userAdmin = $userAdmin;

        return $this;
    }

    /**
     * @return Collection|UserCarrera[]
     */
    public function getUsersCarrera(): Collection
    {
        return $this->usersCarrera;
    }

    public function addUsersCarrera(UserCarrera $usersCarrera): self
    {
        if (!$this->usersCarrera->contains($usersCarrera)) {
            $this->usersCarrera[] = $usersCarrera;
            $usersCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeUsersCarrera(UserCarrera $usersCarrera): self
    {
        if ($this->usersCarrera->contains($usersCarrera)) {
            $this->usersCarrera->removeElement($usersCarrera);
            // set the owning side to null (unless already changed)
            if ($usersCarrera->getGrupoCarrera() === $this) {
                $usersCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }

    public function getUniversidad(): ?Universidad
    {
        return $this->universidad;
    }

    public function setUniversidad(?Universidad $universidad): self
    {
        $this->universidad = $universidad;

        return $this;
    }

    public function getEspecialidadCarrera(): ?EspecialidadCarrera
    {
        return $this->especialidadCarrera;
    }

    public function setEspecialidadCarrera(?EspecialidadCarrera $especialidadCarrera): self
    {
        $this->especialidadCarrera = $especialidadCarrera;

        return $this;
    }

    /**
     * @return Collection|MuestrasCarreraGrupoCarrera[]
     */
    public function getMuestraCarreraGruposCarrera(): Collection
    {
        return $this->muestraCarreraGruposCarrera;
    }

    public function addMuestraCarreraGruposCarrera(MuestrasCarreraGrupoCarrera $muestraCarreraGruposCarrera): self
    {
        if (!$this->muestraCarreraGruposCarrera->contains($muestraCarreraGruposCarrera)) {
            $this->muestraCarreraGruposCarrera[] = $muestraCarreraGruposCarrera;
            $muestraCarreraGruposCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeMuestraCarreraGruposCarrera(MuestrasCarreraGrupoCarrera $muestraCarreraGruposCarrera): self
    {
        if ($this->muestraCarreraGruposCarrera->contains($muestraCarreraGruposCarrera)) {
            $this->muestraCarreraGruposCarrera->removeElement($muestraCarreraGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($muestraCarreraGruposCarrera->getGrupoCarrera() === $this) {
                $muestraCarreraGruposCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }
}
