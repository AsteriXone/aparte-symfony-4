<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesorGrupoCarreraRepository")
 */
class ProfesorGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProfesorCarrera", inversedBy="profesorGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profesor_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="profesoresGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    public function __toString(){
        // TODO: aniadir grupo
        return $this->profesor_carrera->getNombreCompleto();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfesorCarrera(): ?ProfesorCarrera
    {
        return $this->profesor_carrera;
    }

    public function setProfesorCarrera(?ProfesorCarrera $profesor_carrera): self
    {
        $this->profesor_carrera = $profesor_carrera;

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
}
