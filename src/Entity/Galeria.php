<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GaleriaRepository")
 */
class Galeria
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre_galeria;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $carpeta;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageGallery", mappedBy="galeria", orphanRemoval=true)
     */
    private $imagesGallery;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $tipo_galleria;

    public function __construct()
    {
        $this->imagesGallery = new ArrayCollection();
    }

    public function __toString(){
        return $this->nombre_galeria;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreGaleria(): ?string
    {
        return $this->nombre_galeria;
    }

    public function setNombreGaleria(string $nombre_galeria): self
    {
        $this->nombre_galeria = $nombre_galeria;

        return $this;
    }

    public function getCarpeta(): ?string
    {
        return $this->carpeta;
    }

    public function setCarpeta(string $carpeta): self
    {
        $this->carpeta = $carpeta;

        return $this;
    }

    /**
     * @return Collection|ImageGallery[]
     */
    public function getImagesGallery(): Collection
    {
        return $this->imagesGallery;
    }

    public function addImagesGallery(ImageGallery $imagesGallery): self
    {
        if (!$this->imagesGallery->contains($imagesGallery)) {
            $this->imagesGallery[] = $imagesGallery;
            $imagesGallery->setGaleria($this);
        }

        return $this;
    }

    public function removeImagesGallery(ImageGallery $imagesGallery): self
    {
        if ($this->imagesGallery->contains($imagesGallery)) {
            $this->imagesGallery->removeElement($imagesGallery);
            // set the owning side to null (unless already changed)
            if ($imagesGallery->getGaleria() === $this) {
                $imagesGallery->setGaleria(null);
            }
        }

        return $this;
    }

    public function getTipoGalleria(): ?string
    {
        return $this->tipo_galleria;
    }

    public function setTipoGalleria(string $tipo_galleria): self
    {
        $this->tipo_galleria = $tipo_galleria;

        return $this;
    }
}
