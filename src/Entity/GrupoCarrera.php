<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass="App\Repository\GrupoCarreraRepository")
 * @Vich\Uploadable
 */
class GrupoCarrera
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVotacionesActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAdmin", inversedBy="gruposCarrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAdmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $usersCarrera;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Universidad", inversedBy="grupo_carrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $universidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EspecialidadCarrera", inversedBy="grupo_carrera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidadCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MuestrasCarreraGrupoCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $muestraCarreraGruposCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ColorBecasCarreraGrupoCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $colorBecaCarreraGruposCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductosCarreraGrupoCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $productoCarreraGruposCarrera;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfesorGrupoCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $profesoresGruposCarrera;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroMaximoVotarProfes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroMaximoVotarOrlas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroMaximoVotarColorBecas;

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
     * @ORM\OneToMany(targetEntity="App\Entity\CuadrantesGruposCarrera", mappedBy="grupo_carrera", orphanRemoval=true)
     */
    private $cuadrantesGruposCarreras;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProcesoOrlaGrupo", mappedBy="grupo_carrera", cascade={"persist", "remove"})
     */
    private $procesoOrlaGrupo;

    public function __construct()
    {
        $this->usersCarrera = new ArrayCollection();
        $this->muestraCarreraGruposCarrera = new ArrayCollection();
        $this->colorBecaCarreraGruposCarrera = new ArrayCollection();
        $this->profesoresGruposCarrera = new ArrayCollection();
        $this->productoCarreraGruposCarrera = new ArrayCollection();
        $this->cuadrantesGruposCarreras = new ArrayCollection();
    }

    public function __toString()
    {
        // TODO: Return String Data Carrera (Universidad-Especialidad)
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

    public function getIsVotacionesActive(): ?bool
    {
        return $this->isVotacionesActive;
    }

    public function setIsVotacionesActive(bool $isVotacionesActive): self
    {
        $this->isVotacionesActive = $isVotacionesActive;

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
     * @return Collection|UserCarrera[]
     */
    public function getUsersCarrera(): Collection
    {
        return $this->usersCarrera;
    }

    public function addUsersCarrera(UserCarrera $usersCarrera): self
    {
        if (!$this->usersCarrera->contains($usersCarrera)) {
            $this->usersCarrera[] = $usersCarrera;
            $usersCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeUsersCarrera(UserCarrera $usersCarrera): self
    {
        if ($this->usersCarrera->contains($usersCarrera)) {
            $this->usersCarrera->removeElement($usersCarrera);
            // set the owning side to null (unless already changed)
            if ($usersCarrera->getGrupoCarrera() === $this) {
                $usersCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }

    public function getUniversidad(): ?Universidad
    {
        return $this->universidad;
    }

    public function setUniversidad(?Universidad $universidad): self
    {
        $this->universidad = $universidad;

        return $this;
    }

    public function getEspecialidadCarrera(): ?EspecialidadCarrera
    {
        return $this->especialidadCarrera;
    }

    public function setEspecialidadCarrera(?EspecialidadCarrera $especialidadCarrera): self
    {
        $this->especialidadCarrera = $especialidadCarrera;

        return $this;
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
            $muestraCarreraGruposCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeMuestraCarreraGruposCarrera(MuestrasCarreraGrupoCarrera $muestraCarreraGruposCarrera): self
    {
        if ($this->muestraCarreraGruposCarrera->contains($muestraCarreraGruposCarrera)) {
            $this->muestraCarreraGruposCarrera->removeElement($muestraCarreraGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($muestraCarreraGruposCarrera->getGrupoCarrera() === $this) {
                $muestraCarreraGruposCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProfesorGrupoCarrera[]
     */
    public function getProfesoresGruposCarrera(): Collection
    {
        return $this->profesoresGruposCarrera;
    }

    public function addProfesoresGruposCarrera(ProfesorGrupoCarrera $profesoresGruposCarrera): self
    {
        if (!$this->profesoresGruposCarrera->contains($profesoresGruposCarrera)) {
            $this->profesoresGruposCarrera[] = $profesoresGruposCarrera;
            $profesoresGruposCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeProfesoresGruposCarrera(ProfesorGrupoCarrera $profesoresGruposCarrera): self
    {
        if ($this->profesoresGruposCarrera->contains($profesoresGruposCarrera)) {
            $this->profesoresGruposCarrera->removeElement($profesoresGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($profesoresGruposCarrera->getGrupoCarrera() === $this) {
                $profesoresGruposCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }

    public function getNumeroMaximoVotarProfes(): ?int
    {
        return $this->numeroMaximoVotarProfes;
    }

    public function setNumeroMaximoVotarProfes(?int $numeroMaximoVotarProfes): self
    {
        $this->numeroMaximoVotarProfes = $numeroMaximoVotarProfes;

        return $this;
    }

    public function getNumeroMaximoVotarOrlas(): ?int
    {
        return $this->numeroMaximoVotarOrlas;
    }

    public function setNumeroMaximoVotarOrlas(?int $numeroMaximoVotarOrlas): self
    {
        $this->numeroMaximoVotarOrlas = $numeroMaximoVotarOrlas;

        return $this;
    }
    // Contrato
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

    /**
     * @return Collection|ProductosCarreraGrupoCarrera[]
     */
    public function getProductoCarreraGruposCarrera(): Collection
    {
        return $this->productoCarreraGruposCarrera;
    }

    public function addProductoCarreraGruposCarrera(ProductosCarreraGrupoCarrera $productoCarreraGruposCarrera): self
    {
        if (!$this->productoCarreraGruposCarrera->contains($productoCarreraGruposCarrera)) {
            $this->productoCarreraGruposCarrera[] = $productoCarreraGruposCarrera;
            $productoCarreraGruposCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeProductoCarreraGruposCarrera(ProductosCarreraGrupoCarrera $productoCarreraGruposCarrera): self
    {
        if ($this->productoCarreraGruposCarrera->contains($productoCarreraGruposCarrera)) {
            $this->productoCarreraGruposCarrera->removeElement($productoCarreraGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($productoCarreraGruposCarrera->getGrupoCarrera() === $this) {
                $productoCarreraGruposCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CuadrantesGruposCarrera[]
     */
    public function getCuadrantesGruposCarreras(): Collection
    {
        return $this->cuadrantesGruposCarreras;
    }

    public function addCuadrantesGruposCarrera(CuadrantesGruposCarrera $cuadrantesGruposCarrera): self
    {
        if (!$this->cuadrantesGruposCarreras->contains($cuadrantesGruposCarrera)) {
            $this->cuadrantesGruposCarreras[] = $cuadrantesGruposCarrera;
            $cuadrantesGruposCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeCuadrantesGruposCarrera(CuadrantesGruposCarrera $cuadrantesGruposCarrera): self
    {
        if ($this->cuadrantesGruposCarreras->contains($cuadrantesGruposCarrera)) {
            $this->cuadrantesGruposCarreras->removeElement($cuadrantesGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($cuadrantesGruposCarrera->getGrupoCarrera() === $this) {
                $cuadrantesGruposCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
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
            $colorBecaCarreraGruposCarrera->setGrupoCarrera($this);
        }

        return $this;
    }

    public function removeColorBecaCarreraGruposCarrera(ColorBecasCarreraGrupoCarrera $colorBecaCarreraGruposCarrera): self
    {
        if ($this->colorBecaCarreraGruposCarrera->contains($colorBecaCarreraGruposCarrera)) {
            $this->colorBecaCarreraGruposCarrera->removeElement($colorBecaCarreraGruposCarrera);
            // set the owning side to null (unless already changed)
            if ($colorBecaCarreraGruposCarrera->getGrupoCarrera() === $this) {
                $colorBecaCarreraGruposCarrera->setGrupoCarrera(null);
            }
        }

        return $this;
    }

    public function getNumeroMaximoVotarColorBecas(): ?int
    {
        return $this->numeroMaximoVotarColorBecas;
    }

    public function setNumeroMaximoVotarColorBecas(?int $numeroMaximoVotarColorBecas): self
    {
        $this->numeroMaximoVotarColorBecas = $numeroMaximoVotarColorBecas;

        return $this;
    }

    public function getProcesoOrlaGrupo(): ?ProcesoOrlaGrupo
    {
        return $this->procesoOrlaGrupo;
    }

    public function setProcesoOrlaGrupo(ProcesoOrlaGrupo $procesoOrlaGrupo): self
    {
        $this->procesoOrlaGrupo = $procesoOrlaGrupo;

        // set the owning side of the relation if necessary
        if ($this !== $procesoOrlaGrupo->getGrupoCarrera()) {
            $procesoOrlaGrupo->setGrupoCarrera($this);
        }

        return $this;
    }
}
