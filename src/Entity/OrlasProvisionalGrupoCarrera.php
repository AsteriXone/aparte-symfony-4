<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OrlasProvisionalGrupoCarreraRepository")
 * @Vich\Uploadable
 */
class OrlasProvisionalGrupoCarrera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="orla_provisional_carrera", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GrupoCarrera", inversedBy="orlasProvisionalGrupoCarreras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo_carrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisualizacionOrlaGrupoCarrera", mappedBy="orlaProvisionalGrupoCarrera", orphanRemoval=true)
     */
    private $visualizacionesOrlaGrupoCarreras;

    public function __construct()
    {
        $this->visualizacionesOrlaGrupoCarreras = new ArrayCollection();
    }

    public function __toString(){
        return $this->imageName;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

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
     * @return Collection|VisualizacionOrlaGrupoCarrera[]
     */
    public function getVisualizacionesOrlaGrupoCarreras(): Collection
    {
        return $this->visualizacionesOrlaGrupoCarreras;
    }

    public function addVisualizacionesOrlaGrupoCarrera(VisualizacionOrlaGrupoCarrera $visualizacionesOrlaGrupoCarrera): self
    {
        if (!$this->visualizacionesOrlaGrupoCarreras->contains($visualizacionesOrlaGrupoCarrera)) {
            $this->visualizacionesOrlaGrupoCarreras[] = $visualizacionesOrlaGrupoCarrera;
            $visualizacionesOrlaGrupoCarrera->setOrlaProvisionalGrupoCarrera($this);
        }

        return $this;
    }

    public function removeVisualizacionesOrlaGrupoCarrera(VisualizacionOrlaGrupoCarrera $visualizacionesOrlaGrupoCarrera): self
    {
        if ($this->visualizacionesOrlaGrupoCarreras->contains($visualizacionesOrlaGrupoCarrera)) {
            $this->visualizacionesOrlaGrupoCarreras->removeElement($visualizacionesOrlaGrupoCarrera);
            // set the owning side to null (unless already changed)
            if ($visualizacionesOrlaGrupoCarrera->getOrlaProvisionalGrupoCarrera() === $this) {
                $visualizacionesOrlaGrupoCarrera->setOrlaProvisionalGrupoCarrera(null);
            }
        }

        return $this;
    }
}
