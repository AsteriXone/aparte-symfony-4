<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CitasFechaCuadranteGrupoCarreraRepository")
 */
class CitasFechaCuadranteGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FechaCuadranteGrupoCarrera", inversedBy="citasFechaCuadranteGrupoCarreras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fechaCuadrante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCarrera", inversedBy="citasFechaCuadranteGrupoCarreras")
     */
    private $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnlyHora(){
        if ($this->hora){
            return $this->hora->format('H:i');
        } else {
            return 'No se estableció';
        }
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getFechaCuadrante(): ?FechaCuadranteGrupoCarrera
    {
        return $this->fechaCuadrante;
    }

    public function setFechaCuadrante(?FechaCuadranteGrupoCarrera $fechaCuadrante): self
    {
        $this->fechaCuadrante = $fechaCuadrante;

        return $this;
    }

    public function getUsuario(): ?UserCarrera
    {
        return $this->usuario;
    }

    public function setUsuario(?UserCarrera $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
