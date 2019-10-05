<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MuestrasCarreraRepository")
 * @Vich\Uploadable
 */
class MuestrasCarrera
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
     * @Vich\UploadableField(mapping="muestra_carrera", fileNameProperty="imageName")
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
     * @ORM\OneToMany(targetEntity="App\Entity\MuestrasCarreraGrupoCarrera", mappedBy="muestras_carrera", orphanRemoval=true)
     */
    private $muestraCarreraGruposCarrera;

    public function __construct()
    {
        $this->muestraCarreraGruposCarrera = new ArrayCollection();
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
     * @return Collection|MuestrasCarreraGrupoCarrera[]
     */
    public function getMuestraCarreraGruposCarrera(): Collection
    {
        return $this->muestraCarreraGruposCarrera;
    }

    public function addMuestraCarreraGruposCarrera(MuestrasCarreraGrupoCarrera $muestraCarreraGruposCarrera): self
    {
        if (!$this->muestraCarreraGruposCarrera->contains($muestraCarreraGruposCarrera)) {
            $this->muestraCarreraGruposCarrera[] = $muestraCarreraGruposCarrera;
            $muestraCarreraGruposCarrera->setMuestrasCarrera($this);
        }

        return $this;
    }

    public function removeMuestraCarreraGruposCarrera(MuestrasCarreraGrupoCarrera $muestraCarreraGruposCarrera): self
    {
        if ($this->muestraCarreraGruposCarrera->contains($muestraCarreraGruposCarrera)) {
            $this->muestraCarreraGruposCarrera->removeElement($muestraCarreraGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($muestraCarreraGruposCarrera->getMuestrasCarrera() === $this) {
                $muestraCarreraGruposCarrera->setMuestrasCarrera(null);
            }
        }

        return $this;
    }
}
