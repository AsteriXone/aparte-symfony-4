<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserCarreraRepository")
 */
class UserCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="usersCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesProfesorCarrera", mappedBy="user_carrera", cascade={"persist", "remove"})
     */
    private $votacionesProfesorCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesColorBecaCarrera", mappedBy="user_carrera", cascade={"persist", "remove"})
     */
    private $votacionesColorBecaCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesMuestraCarrera", mappedBy="user_carrera", cascade={"persist", "remove"})
     */
    private $votacionesMuestraCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CitasFechaCuadranteGrupoCarrera", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $citasFechaCuadranteGrupoCarreras;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Resegnia", mappedBy="user_carrera", cascade={"persist", "remove"})
     */
    private $resegnia;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isVotarCitasActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IncidenciasCarrera", mappedBy="user_carrera")
     */
    private $incidenciasCarreras;

    public function __construct()
    {
        $this->votacionesColorBecaCarrera = new ArrayCollection();
        $this->votacionesProfesorCarrera = new ArrayCollection();
        $this->votacionesMuestraCarrera = new ArrayCollection();
        $this->citasFechaCuadranteGrupoCarreras = new ArrayCollection();
        $this->incidenciasCarreras = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUser()->getEmail() ?: '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $votacionesProfesorCarrera->setUserCarrera($this);
        }

        return $this;
    }

    public function removeVotacionesProfesorCarrera(VotacionesProfesorCarrera $votacionesProfesorCarrera): self
    {
        if ($this->votacionesProfesorCarrera->contains($votacionesProfesorCarrera)) {
            $this->votacionesProfesorCarrera->removeElement($votacionesProfesorCarrera);
            // set the owning side to null (unless already changed)
            if ($votacionesProfesorCarrera->getUserCarrera() === $this) {
                $votacionesProfesorCarrera->setUserCarrera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VotacionesMuestraCarrera[]
     */
    public function getVotacionesMuestraCarrera(): Collection
    {
        return $this->votacionesMuestraCarrera;
    }

    public function addVotacionesMuestraCarrera(VotacionesMuestraCarrera $votacionesMuestraCarrera): self
    {
        if (!$this->votacionesMuestraCarrera->contains($votacionesMuestraCarrera)) {
            $this->votacionesMuestraCarrera[] = $votacionesMuestraCarrera;
            $votacionesMuestraCarrera->setUserCarrera($this);
        }

        return $this;
    }

    public function removeVotacionesMuestraCarrera(VotacionesMuestraCarrera $votacionesMuestraCarrera): self
    {
        if ($this->votacionesMuestraCarrera->contains($votacionesMuestraCarrera)) {
            $this->votacionesMuestraCarrera->removeElement($votacionesMuestraCarrera);
            // set the owning side to null (unless already changed)
            if ($votacionesMuestraCarrera->getUserCarrera() === $this) {
                $votacionesMuestraCarrera->setUserCarrera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CitasFechaCuadranteGrupoCarrera[]
     */
    public function getCitasFechaCuadranteGrupoCarreras(): Collection
    {
        return $this->citasFechaCuadranteGrupoCarreras;
    }

    public function addCitasFechaCuadranteGrupoCarrera(CitasFechaCuadranteGrupoCarrera $citasFechaCuadranteGrupoCarrera): self
    {
        if (!$this->citasFechaCuadranteGrupoCarreras->contains($citasFechaCuadranteGrupoCarrera)) {
            $this->citasFechaCuadranteGrupoCarreras[] = $citasFechaCuadranteGrupoCarrera;
            $citasFechaCuadranteGrupoCarrera->setUsuario($this);
        }

        return $this;
    }

    public function removeCitasFechaCuadranteGrupoCarrera(CitasFechaCuadranteGrupoCarrera $citasFechaCuadranteGrupoCarrera): self
    {
        if ($this->citasFechaCuadranteGrupoCarreras->contains($citasFechaCuadranteGrupoCarrera)) {
            $this->citasFechaCuadranteGrupoCarreras->removeElement($citasFechaCuadranteGrupoCarrera);
            // set the owning side to null (unless already changed)
            if ($citasFechaCuadranteGrupoCarrera->getUsuario() === $this) {
                $citasFechaCuadranteGrupoCarrera->setUsuario(null);
            }
        }

        return $this;
    }

    public function getResegnia(): ?Resegnia
    {
        return $this->resegnia;
    }

    public function setResegnia(Resegnia $resegnia): self
    {
        $this->resegnia = $resegnia;

        // set the owning side of the relation if necessary
        if ($this !== $resegnia->getUserCarrera()) {
            $resegnia->setUserCarrera($this);
        }

        return $this;
    }

    public function getIsVotarCitasActive(): ?bool
    {
        return $this->isVotarCitasActive;
    }

    public function setIsVotarCitasActive(?bool $isVotarCitasActive): self
    {
        $this->isVotarCitasActive = $isVotarCitasActive;

        return $this;
    }

    /**
     * @return Collection|VotacionesColorBecaCarrera[]
     */
    public function getVotacionesColorBecaCarrera(): Collection
    {
        return $this->votacionesColorBecaCarrera;
    }

    public function addVotacionesColorBecaCarrera(VotacionesColorBecaCarrera $votacionesColorBecaCarrera): self
    {
        if (!$this->votacionesColorBecaCarrera->contains($votacionesColorBecaCarrera)) {
            $this->votacionesColorBecaCarrera[] = $votacionesColorBecaCarrera;
            $votacionesColorBecaCarrera->setUserCarrera($this);
        }

        return $this;
    }

    public function removeVotacionesColorBecaCarrera(VotacionesColorBecaCarrera $votacionesColorBecaCarrera): self
    {
        if ($this->votacionesColorBecaCarrera->contains($votacionesColorBecaCarrera)) {
            $this->votacionesColorBecaCarrera->removeElement($votacionesColorBecaCarrera);
            // set the owning side to null (unless already changed)
            if ($votacionesColorBecaCarrera->getUserCarrera() === $this) {
                $votacionesColorBecaCarrera->setUserCarrera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IncidenciasCarrera[]
     */
    public function getIncidenciasCarreras(): Collection
    {
        return $this->incidenciasCarreras;
    }

    public function addIncidenciasCarrera(IncidenciasCarrera $incidenciasCarrera): self
    {
        if (!$this->incidenciasCarreras->contains($incidenciasCarrera)) {
            $this->incidenciasCarreras[] = $incidenciasCarrera;
            $incidenciasCarrera->setUserCarrera($this);
        }

        return $this;
    }

    public function removeIncidenciasCarrera(IncidenciasCarrera $incidenciasCarrera): self
    {
        if ($this->incidenciasCarreras->contains($incidenciasCarrera)) {
            $this->incidenciasCarreras->removeElement($incidenciasCarrera);
            // set the owning side to null (unless already changed)
            if ($incidenciasCarrera->getUserCarrera() === $this) {
                $incidenciasCarrera->setUserCarrera(null);
            }
        }

        return $this;
    }
}
