<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MuestrasCarreraGrupoCarreraRepository")
 */
class MuestrasCarreraGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MuestrasCarrera", inversedBy="muestraCarreraGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $muestras_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="muestraCarreraGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $votos;

    public function __toString(){
        $nombreImagen = $this->muestras_carrera->getImageName();
        $grupo = $this->grupo_carrera->getCodigoGrupo();
        $cadena = $nombreImagen.' - '.$grupo;
        return $cadena;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMuestrasCarrera(): ?MuestrasCarrera
    {
        return $this->muestras_carrera;
    }

    public function setMuestrasCarrera(?MuestrasCarrera $muestras_carrera): self
    {
        $this->muestras_carrera = $muestras_carrera;

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

    public function getVotos(): ?int
    {
        return $this->votos;
    }

    public function setVotos(?int $votos): self
    {
        $this->votos = $votos;

        return $this;
    }
}
