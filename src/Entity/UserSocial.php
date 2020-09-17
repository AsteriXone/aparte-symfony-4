<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class UserSocial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userSocial")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoSocial", inversedBy="usersSocial")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_social;

    public function __construct()
    {
        // $this->citasFechaCuadranteGrupoCarreras = new ArrayCollection();
        // $this->incidenciasCarreras = new ArrayCollection();
        // $this->visualizacionesOrlaGrupoCarrera = new ArrayCollection();
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

    public function getGrupoSocial(): ?GrupoSocial
    {
        return $this->grupo_social;
    }

    public function setGrupoSocial(?GrupoSocial $grupo_social): self
    {
        $this->grupo_social = $grupo_social;

        return $this;
    }


    // public function getResegnia(): ?Resegnia
    // {
    //     return $this->resegnia;
    // }
    //
    // public function setResegnia(Resegnia $resegnia): self
    // {
    //     $this->resegnia = $resegnia;
    //
    //     // set the owning side of the relation if necessary
    //     if ($this !== $resegnia->getUserCarrera()) {
    //         $resegnia->setUserCarrera($this);
    //     }
    //
    //     return $this;
    // }

    // public function getIsVotarCitasActive(): ?bool
    // {
    //     return $this->isVotarCitasActive;
    // }
    //
    // public function setIsVotarCitasActive(?bool $isVotarCitasActive): self
    // {
    //     $this->isVotarCitasActive = $isVotarCitasActive;
    //
    //     return $this;
    // }

    /**
     * @ return Collection|IncidenciasCarrera[]
     */
    // public function getIncidenciasCarreras(): Collection
    // {
    //     return $this->incidenciasCarreras;
    // }
    //
    // public function addIncidenciasCarrera(IncidenciasCarrera $incidenciasCarrera): self
    // {
    //     if (!$this->incidenciasCarreras->contains($incidenciasCarrera)) {
    //         $this->incidenciasCarreras[] = $incidenciasCarrera;
    //         $incidenciasCarrera->setUserCarrera($this);
    //     }
    //
    //     return $this;
    // }
    //
    // public function removeIncidenciasCarrera(IncidenciasCarrera $incidenciasCarrera): self
    // {
    //     if ($this->incidenciasCarreras->contains($incidenciasCarrera)) {
    //         $this->incidenciasCarreras->removeElement($incidenciasCarrera);
    //         // set the owning side to null (unless already changed)
    //         if ($incidenciasCarrera->getUserCarrera() === $this) {
    //             $incidenciasCarrera->setUserCarrera(null);
    //         }
    //     }
    //
    //     return $this;
    // }
}
