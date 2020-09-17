<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function __toString()
    {
        return $this->getEmail() ?: '';
    }

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserAdmin", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userAdmin;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $apellido_1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $apellido_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telefono;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mencion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isErasmus;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $fecha_registro;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserCarrera", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userCarrera;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserSocial", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userSocial;

    public function getNombreCompleto(){
        $nombre = $this->getNombre();
        $ape1 = $this->getApellido1();
        $ape2 = $this->getApellido2();
        $nombreCompleto = "";
        if ($ape1 && $ape2){
            $nombreCompleto = $ape1." ".$ape2.", ".$nombre;
        } elseif ($ape1){
            $nombreCompleto = $ape1.", ".$nombre;
        } else {
            $nombreCompleto = $nombre;
        }
        return $nombreCompleto;
    }

    public function getNombreCompletoResenia(){
        $nombre = $this->getNombre();
        $ape1 = $this->getApellido1();
        $ape2 = $this->getApellido2();
        $nombreCompleto = "";
        if ($ape1 && $ape2){
            $nombreCompleto = $nombre." ".$ape1." ".$ape2;
        } elseif ($ape1){
            $nombreCompleto = $nombre." ".$ape1;
        } else {
            $nombreCompleto = $nombre;
        }
        return $nombreCompleto;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnlyDate(){
        if ($this->fecha_registro){
            return $this->fecha_registro->format('d/m/Y');
        } else {
            return 'No se estableció';
        }
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserAdmin(): ?UserAdmin
    {
        return $this->userAdmin;
    }

    public function setUserAdmin(UserAdmin $userAdmin): self
    {
        $this->userAdmin = $userAdmin;

        // set the owning side of the relation if necessary
        if ($this !== $userAdmin->getUser()) {
            $userAdmin->setUser($this);
        }

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido_1;
    }

    public function setApellido1(?string $apellido_1): self
    {
        $this->apellido_1 = $apellido_1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido_2;
    }

    public function setApellido2(?string $apellido_2): self
    {
        $this->apellido_2 = $apellido_2;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getMencion(): ?bool
    {
        return $this->mencion;
    }

    public function setMencion(bool $mencion): self
    {
        $this->mencion = $mencion;

        return $this;
    }

    public function getIsErasmus(): ?bool
    {
        return $this->isErasmus;
    }

    public function setIsErasmus(bool $isErasmus): self
    {
        $this->isErasmus = $isErasmus;

        return $this;
    }

    public function getUserCarrera(): ?UserCarrera
    {
        return $this->userCarrera;
    }

    public function setUserCarrera(UserCarrera $userCarrera): self
    {
        $this->userCarrera = $userCarrera;

        // set the owning side of the relation if necessary
        if ($this !== $userCarrera->getUser()) {
            $userCarrera->setUser($this);
        }

        return $this;
    }

    public function getUserSocial(): ?UserSocial
    {
        return $this->userSocial;
    }

    public function setUserSocial(UserSocial $userSocial): self
    {
        $this->userSocial = $userSocial;

        // set the owning side of the relation if necessary
        if ($this !== $userSocial->getUser()) {
            $userSocial->setUser($this);
        }

        return $this;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro(?\DateTimeInterface $fecha_registro): self
    {
        $this->fecha_registro = $fecha_registro;

        return $this;
    }
}
