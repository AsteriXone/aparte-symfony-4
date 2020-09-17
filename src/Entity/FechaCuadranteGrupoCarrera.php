<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FechaCuadranteGrupoCarreraRepository")
 */
class FechaCuadranteGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cuadrantes", inversedBy="fechasCuadranteCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cuadrante;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CitasFechaCuadranteGrupoCarrera", mappedBy="fechaCuadrante", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $citasFechaCuadranteGrupoCarreras;

    // Unmapped Fields
    private $hIni;
    private $hFin;
    private $dIni;
    private $dFin;
    private $cantidad;

    public function getOnlyFecha(){
        if ($this->fecha){
            return $this->fecha->format('d/m/Y');
        } else {
            return 'No se estableció';
        }
    }

    public function getHIni(): ?\DateTimeInterface{
        return $this->hIni;
    }

    public function setHIni(\DateTimeInterface $hIni){
        $this->hIni = $hIni;
        return $this;
    }

    public function getHFin(): ?\DateTimeInterface{
        return $this->hFin;
    }

    public function setHFin(\DateTimeInterface $hFin){
        $this->hFin = $hFin;
        return $this;
    }

    public function getDIni(): ?\DateTimeInterface{
        return $this->dIni;
    }

    public function setDIni(\DateTimeInterface $dIni){
        $this->dIni = $dIni;
    }

    public function getDFin(): ?\DateTimeInterface{
        return $this->dFin;
    }

    public function setDFin(\DateTimeInterface $dFin){
        $this->dFin = $dFin;
        return $this;
    }

    public function getCantidad(): ?int{
        return $this->cantidad;
    }

    public function setCantidad(?int $cantidad){
        $this->cantidad = $cantidad;
        return $this;
    }

    // End Unmapped Fields


    public function __construct()
    {
        $this->citasFechaCuadranteGrupoCarreras = new ArrayCollection();
    }

    public function __toString(){
        return 'Citas para cuadrante '.$this->cuadrante.' con fecha '.date_format($this->fecha, 'd-M-Y');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCuadrante(): ?Cuadrantes
    {
        return $this->cuadrante;
    }

    public function setCuadrante(?Cuadrantes $cuadrante): self
    {
        $this->cuadrante = $cuadrante;

        return $this;
    }

    /**
     * @return Collection|CitasFechaCuadranteGrupoCarrera[]
     */
    public function getCitasFechaCuadranteGrupoCarreras(): Collection
    {
        return $this->citasFechaCuadranteGrupoCarreras;
    }

    public function addCitasFechaCuadranteGrupoCarrera(CitasFechaCuadranteGrupoCarrera $citasFechaCuadranteGrupoCarrera): self
    {
        if (!$this->citasFechaCuadranteGrupoCarreras->contains($citasFechaCuadranteGrupoCarrera)) {
            $this->citasFechaCuadranteGrupoCarreras[] = $citasFechaCuadranteGrupoCarrera;
            $citasFechaCuadranteGrupoCarrera->setFechaCuadrante($this);
        }

        return $this;
    }

    public function removeCitasFechaCuadranteGrupoCarrera(CitasFechaCuadranteGrupoCarrera $citasFechaCuadranteGrupoCarrera): self
    {
        if ($this->citasFechaCuadranteGrupoCarreras->contains($citasFechaCuadranteGrupoCarrera)) {
            $this->citasFechaCuadranteGrupoCarreras->removeElement($citasFechaCuadranteGrupoCarrera);
            // set the owning side to null (unless already changed)
            if ($citasFechaCuadranteGrupoCarrera->getFechaCuadrante() === $this) {
                $citasFechaCuadranteGrupoCarrera->setFechaCuadrante(null);
            }
        }

        return $this;
    }
}
