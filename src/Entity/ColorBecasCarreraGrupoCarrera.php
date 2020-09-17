<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorBecasCarreraGrupoCarreraRepository")
 */
class ColorBecasCarreraGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ColorBecasCarrera", inversedBy="colorBecaCarreraGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $colorBecas_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="colorBecaCarreraGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $votos;

    public function __toString(){
        $nombreImagen = $this->colorBecas_carrera->getImageName();
        $grupo = $this->grupo_carrera->getCodigoGrupo();
        $cadena = $nombreImagen.' - '.$grupo;
        return $cadena;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColorBecasCarrera(): ?ColorBecasCarrera
    {
        return $this->colorBecas_carrera;
    }

    public function setColorBecasCarrera(?ColorBecasCarrera $colorBecas_carrera): self
    {
        $this->colorBecas_carrera = $colorBecas_carrera;

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

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(?int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}
