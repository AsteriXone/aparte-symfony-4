<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisualizacionOrlaGrupoCarreraRepository")
 */
class VisualizacionOrlaGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCarrera", inversedBy="visualizacionesOrlaGrupoCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCarrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrlasProvisionalGrupoCarrera", inversedBy="visualizacionesOrlaGrupoCarreras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orlaProvisionalGrupoCarrera;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaVisualizacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnlyDate(){
        if ($this->fechaVisualizacion){
            return $this->fechaVisualizacion->format('d/m/Y');
        } else {
            return 'No se estableció';
        }
    }

    public function getUserCarrera(): ?UserCarrera
    {
        return $this->userCarrera;
    }

    public function setUserCarrera(?UserCarrera $userCarrera): self
    {
        $this->userCarrera = $userCarrera;

        return $this;
    }

    public function getOrlaProvisionalGrupoCarrera(): ?OrlasProvisionalGrupoCarrera
    {
        return $this->orlaProvisionalGrupoCarrera;
    }

    public function setOrlaProvisionalGrupoCarrera(?OrlasProvisionalGrupoCarrera $orlaProvisionalGrupoCarrera): self
    {
        $this->orlaProvisionalGrupoCarrera = $orlaProvisionalGrupoCarrera;

        return $this;
    }

    public function getFechaVisualizacion(): ?\DateTimeInterface
    {
        return $this->fechaVisualizacion;
    }

    public function setFechaVisualizacion(?\DateTimeInterface $fechaVisualizacion): self
    {
        $this->fechaVisualizacion = $fechaVisualizacion;

        return $this;
    }
}
