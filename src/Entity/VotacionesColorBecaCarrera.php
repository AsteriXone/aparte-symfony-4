<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VotacionesColorBecaCarreraRepository")
 */
class VotacionesColorBecaCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCarrera", inversedBy="votacionesColorBecaCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ColorBecasCarrera", inversedBy="votacionesColorBecaCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $colorBeca_carrera;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCarrera(): ?UserCarrera
    {
        return $this->user_carrera;
    }

    public function setUserCarrera(?UserCarrera $user_carrera): self
    {
        $this->user_carrera = $user_carrera;

        return $this;
    }

    public function getColorBecaCarrera(): ?ColorBecasCarrera
    {
        return $this->colorBeca_carrera;
    }

    public function setColorBecaCarrera(?ColorBecasCarrera $colorBeca_carrera): self
    {
        $this->colorBeca_carrera = $colorBeca_carrera;

        return $this;
    }
}
