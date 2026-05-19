<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Entidad que representa un usuario registrado en la plataforma
#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    // Guardamos el hash de la contraseña, nunca en texto plano
    #[ORM\Column(length: 255)]
    private ?string $passwordHash = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?\DateTime $fechaRegistro = null;

    // Solo mostramos los últimos 4 dígitos de la tarjeta (enmascarada)
    #[ORM\Column(length: 255)]
    private ?string $metodoPagoEnmascarado = null;

    // Estado del usuario: activo, suspendido, etc.
    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(length: 255)]
    private ?string $metodoPagoTipo = null;

    // Un usuario puede tener varias listas de reproducción
    #[ORM\OneToMany(targetEntity: ListaReproduccion::class, mappedBy: 'usuario')]
    private Collection $listasReproduccion;

    #[ORM\OneToMany(targetEntity: Visionado::class, mappedBy: 'usuario')]
    private Collection $visionados;

    public function __construct()
    {
        $this->listasReproduccion = new ArrayCollection();
        $this->visionados = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getPasswordHash(): ?string { return $this->passwordHash; }
    public function setPasswordHash(string $passwordHash): static { $this->passwordHash = $passwordHash; return $this; }

    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }

    public function getFechaRegistro(): ?\DateTime { return $this->fechaRegistro; }
    public function setFechaRegistro(\DateTime $fechaRegistro): static { $this->fechaRegistro = $fechaRegistro; return $this; }

    public function getMetodoPagoEnmascarado(): ?string { return $this->metodoPagoEnmascarado; }
    public function setMetodoPagoEnmascarado(string $metodoPagoEnmascarado): static { $this->metodoPagoEnmascarado = $metodoPagoEnmascarado; return $this; }

    public function getEstado(): ?string { return $this->estado; }
    public function setEstado(string $estado): static { $this->estado = $estado; return $this; }

    public function getMetodoPagoTipo(): ?string { return $this->metodoPagoTipo; }
    public function setMetodoPagoTipo(string $metodoPagoTipo): static { $this->metodoPagoTipo = $metodoPagoTipo; return $this; }

    public function getListasReproduccion(): Collection { return $this->listasReproduccion; }
    public function getVisionados(): Collection { return $this->visionados; }
}
