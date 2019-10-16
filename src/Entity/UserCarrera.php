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
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userCarrera", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="usersCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesProfesorCarrera", mappedBy="user_carrera", orphanRemoval=true)
     */
    private $votacionesProfesorCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesMuestraCarrera", mappedBy="user_carrera", orphanRemoval=true)
     */
    private $votacionesMuestraCarrera;

    public function __construct()
    {
        $this->votacionesProfesorCarrera = new ArrayCollection();
        $this->votacionesMuestraCarrera = new ArrayCollection();
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
}
