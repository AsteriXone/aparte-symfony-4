<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductosCarreraGrupoCarreraRepository")
 */
class ProductosCarreraGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductosCarrera", inversedBy="productoCarreraGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productos_carrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="productoCarreraGruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $precio;

    public function __toString(){
        $nombreImagen = $this->productos_carrera->getImageName();
        $grupo = $this->grupo_carrera->getCodigoGrupo();
        $cadena = $nombreImagen.' - '.$grupo;
        return $cadena;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductosCarrera(): ?ProductosCarrera
    {
        return $this->productos_carrera;
    }

    public function setProductosCarrera(?ProductosCarrera $productos_carrera): self
    {
        $this->productos_carrera = $productos_carrera;

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
