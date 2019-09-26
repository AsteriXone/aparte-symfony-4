<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAdminRepository")
 */
class UserAdmin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userAdmin", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GrupoCarrera", mappedBy="userAdmin", cascade={"persist", "remove"})
     */
    private $gruposCarrera;

    public function __construct()
    {
        $this->gruposCarrera = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->user->getNombre() ?: '';
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

    /**
     * @return Collection|GrupoCarrera[]
     */
    public function getGruposCarrera(): Collection
    {
        return $this->gruposCarrera;
    }

    public function addGruposCarrera(GrupoCarrera $gruposCarrera): self
    {
        if (!$this->gruposCarrera->contains($gruposCarrera)) {
            $this->gruposCarrera[] = $gruposCarrera;
            $gruposCarrera->setUserAdmin($this);
        }

        return $this;
    }

    public function removeGruposCarrera(GrupoCarrera $gruposCarrera): self
    {
        if ($this->gruposCarrera->contains($gruposCarrera)) {
            $this->gruposCarrera->removeElement($gruposCarrera);
            // set the owning side to null (unless already changed)
            if ($gruposCarrera->getUserAdmin() === $this) {
                $gruposCarrera->setUserAdmin(null);
            }
        }

        return $this;
    }
}
