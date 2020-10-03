<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity()
 * @Vich\Uploadable
 */
class GrupoSocial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $codigo_grupo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCitasActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isContratoActive;

    // /**
    //  * @ORM\Column(type="boolean")
    //  */
    // private $isVotacionesActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAdmin", inversedBy="gruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAdmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSocial", mappedBy="grupo_social", orphanRemoval=true)
     */
    private $usersSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $contrato;

    /**
     * @Vich\UploadableField(mapping="contrato_carrera", fileNameProperty="contrato")
     * @var File
     */
    private $contratoFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $contratoUpdateAt;


    /**
     * @ TODO: ORM\OneToMany(targetEntity="App\Entity\CuadrantesGruposCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    // private $cuadrantesGruposCarreras;

    public function __construct()
    {
        $this->usersSocial = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getCodigoGrupo() ?: '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoGrupo(): ?string
    {
        return $this->codigo_grupo;
    }

    public function setCodigoGrupo(?string $codigo_grupo): self
    {
        $this->codigo_grupo = $codigo_grupo;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsCitasActive(): ?bool
    {
        return $this->isCitasActive;
    }

    public function setIsCitasActive(bool $isCitasActive): self
    {
        $this->isCitasActive = $isCitasActive;

        return $this;
    }

    public function getIsContratoActive(): ?bool
    {
        return $this->isContratoActive;
    }

    public function setIsContratoActive(bool $isContratoActive): self
    {
        $this->isContratoActive = $isContratoActive;

        return $this;
    }

    public function getUserAdmin(): ?UserAdmin
    {
        return $this->userAdmin;
    }

    public function setUserAdmin(?UserAdmin $userAdmin): self
    {
        $this->userAdmin = $userAdmin;

        return $this;
    }

    /**
     * @return Collection|UserSocial[]
     */
    public function getUsersSocial(): Collection
    {
        return $this->usersSocial;
    }

    public function addUsersSocial(UserSocial $usersSocial): self
    {
        if (!$this->usersSocial->contains($usersSocial)) {
            $this->usersSocial[] = $usersSocial;
            $usersSocial->setGrupoSocial($this);
        }

        return $this;
    }

    public function removeUsersSocial(UserSocial $usersSocial): self
    {
        if ($this->usersSocial->contains($usersSocial)) {
            $this->usersSocial->removeElement($usersSocial);
            // set the owning side to null (unless already changed)
            if ($usersSocial->getGrupoSocial() === $this) {
                $usersSocial->setGrupoSocial(null);
            }
        }

        return $this;
    }

    public function getContrato(): ?string
    {
        return $this->contrato;
    }

    public function setContrato(?string $contrato): self
    {
        $this->contrato = $contrato;
        $this->contratoUpdateAt = new \DateTime('now');
        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $contratoFile
     */
    public function setContratoFile(?File $contratoFile = null): void
    {
        $this->contratoFile = $contratoFile;
        if (null !== $contratoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->contratoUpdatedAt = new \DateTime('now');
        }
    }

    public function getContratoFile(): ?File
    {
        return $this->contratoFile;
    }

    public function getContratoUpdateAt(): ?\DateTimeInterface
    {
        return $this->contratoUpdateAt;
    }

    public function setContratoUpdateAt(?\DateTimeInterface $contratoUpdateAt): self
    {
        $this->contratoUpdateAt = $contratoUpdateAt;

        return $this;
    }
}
