<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorBecasCarreraRepository")
 * @Vich\Uploadable
 */
class ColorBecasCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="colorBeca_carrera", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ColorBecasCarreraGrupoCarrera", mappedBy="colorBecas_carrera", orphanRemoval=true)
     */
    private $colorBecaCarreraGruposCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VotacionesColorBecaCarrera", mappedBy="colorBeca_carrera", orphanRemoval=true)
     */
    private $votacionesColorBecaCarrera;

    /**
     * Not mapped field to use in votacionesColorBecaCarrera
     */
    private $isVotado = false;

    public function __construct()
    {
        $this->colorBecaCarreraGruposCarrera = new ArrayCollection();
        $this->votacionesColorBecaCarrera = new ArrayCollection();
    }

    public function __toString(){
        return $this->imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return Collection|ColorBecasCarreraGrupoCarrera[]
     */
    public function getColorBecaCarreraGruposCarrera(): Collection
    {
        return $this->colorBecaCarreraGruposCarrera;
    }

    public function addColorBecaCarreraGruposCarrera(ColorBecasCarreraGrupoCarrera $colorBecaCarreraGruposCarrera): self
    {
        if (!$this->colorBecaCarreraGruposCarrera->contains($colorBecaCarreraGruposCarrera)) {
            $this->colorBecaCarreraGruposCarrera[] = $colorBecaCarreraGruposCarrera;
            $colorBecaCarreraGruposCarrera->setColorBecasCarrera($this);
        }

        return $this;
    }

    public function removeColorBecaCarreraGruposCarrera(ColorBecasCarreraGrupoCarrera $colorBecaCarreraGruposCarrera): self
    {
        if ($this->colorBecaCarreraGruposCarrera->contains($colorBecaCarreraGruposCarrera)) {
            $this->colorBecaCarreraGruposCarrera->removeElement($colorBecaCarreraGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($colorBecaCarreraGruposCarrera->getColorBecasCarrera() === $this) {
                $colorBecaCarreraGruposCarrera->setColorBecasCarrera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VotacionesColorBecaCarrera[]
     */
    public function getVotacionesColorBecaCarrera(): Collection
    {
        return $this->votacionesColorBecaCarrera;
    }

    public function addVotacionesColorBecaCarrera(VotacionesColorBecaCarrera $votacionesColorBecaCarrera): self
    {
        if (!$this->votacionesColorBecaCarrera->contains($votacionesColorBecaCarrera)) {
            $this->votacionesColorBecaCarrera[] = $votacionesColorBecaCarrera;
            $votacionesColorBecaCarrera->setColorBecaCarrera($this);
        }

        return $this;
    }

    public function removeVotacionesColorBecaCarrera(VotacionesColorBecaCarrera $votacionesColorBecaCarrera): self
    {
        if ($this->votacionesColorBecaCarrera->contains($votacionesColorBecaCarrera)) {
            $this->votacionesColorBecaCarrera->removeElement($votacionesColorBecaCarrera);
            // set the owning side to null (unless already changed)
            if ($votacionesColorBecaCarrera->getColorBecaCarrera() === $this) {
                $votacionesColorBecaCarrera->setColorBecaCarrera(null);
            }
        }

        return $this;
    }

    public function getIsVotado()
    {
        return $this->isVotado;
    }

    public function setIsVotado($opcion)
    {
        $this->isVotado = $opcion;

        return $this;
    }
}
