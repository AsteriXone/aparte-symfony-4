<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResegniaRepository")
 */
class Resegnia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $calidad_precio;

    /**
     * @ORM\Column(type="integer")
     */
    private $ambiente;

    /**
     * @ORM\Column(type="integer")
     */
    private $trato;

    /**
     * @ORM\Column(type="integer")
     */
    private $accesibilidad;

    /**
     * @ORM\Column(type="integer")
     */
    private $disegnio_opciones;

    /**
     * @ORM\Column(type="string")
     */
    private $comentario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $publicada;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $fecha_publicacion;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserCarrera", inversedBy="resegnia", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_carrera;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalidadPrecio(): ?int
    {
        return $this->calidad_precio;
    }

    public function setCalidadPrecio(int $calidad_precio): self
    {
        $this->calidad_precio = $calidad_precio;

        return $this;
    }

    public function getAmbiente(): ?int
    {
        return $this->ambiente;
    }

    public function setAmbiente(int $ambiente): self
    {
        $this->ambiente = $ambiente;

        return $this;
    }

    public function getTrato(): ?int
    {
        return $this->trato;
    }

    public function setTrato(int $trato): self
    {
        $this->trato = $trato;

        return $this;
    }

    public function getAccesibilidad(): ?int
    {
        return $this->accesibilidad;
    }

    public function setAccesibilidad(int $accesibilidad): self
    {
        $this->accesibilidad = $accesibilidad;

        return $this;
    }

    public function getDisegnioOpciones(): ?int
    {
        return $this->disegnio_opciones;
    }

    public function setDisegnioOpciones(int $disegnio_opciones): self
    {
        $this->disegnio_opciones = $disegnio_opciones;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getPublicada(): ?bool
    {
        return $this->publicada;
    }

    public function setPublicada(bool $publicada): self
    {
        $this->publicada = $publicada;

        return $this;
    }

    public function getUserCarrera(): ?UserCarrera
    {
        return $this->user_carrera;
    }

    public function setUserCarrera(UserCarrera $user_carrera): self
    {
        $this->user_carrera = $user_carrera;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(?\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }
}
