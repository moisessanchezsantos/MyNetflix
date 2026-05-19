<?php

namespace App\Entity;

use App\Repository\VisionadoRepository;
use Doctrine\ORM\Mapping as ORM;

// Registra cada vez que un usuario ve una película (historial de visionados)
#[ORM\Entity(repositoryClass: VisionadoRepository::class)]
class Visionado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $fecha = null;

    // Si el usuario llegó al final de la película
    #[ORM\Column]
    private ?bool $terminada = null;

    // Minuto en el que se quedó (para reanudar la reproducción)
    #[ORM\Column]
    private ?int $marcaTiempoMin = null;

    // Valoración del 1 al 5
    #[ORM\Column]
    private ?int $valoracion = null;

    // De dónde vino: búsqueda, lista, recomendación...
    #[ORM\Column(length: 255)]
    private ?string $origen = null;

    // Relación con el usuario que realizó el visionado (obligatorio)
    #[ORM\ManyToOne(inversedBy: 'visionados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    // Relación con la película vista (obligatorio)
    #[ORM\ManyToOne(inversedBy: 'visionados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pelicula $pelicula = null;

    // Lista de reproducción desde la que se abrió (opcional)
    #[ORM\ManyToOne(inversedBy: 'visionados')]
    private ?ListaReproduccion $listaReproduccion = null;

    public function getId(): ?int { return $this->id; }

    public function getFecha(): ?\DateTime { return $this->fecha; }
    public function setFecha(\DateTime $fecha): static { $this->fecha = $fecha; return $this; }

    public function getTerminada(): ?bool { return $this->terminada; }
    public function setTerminada(bool $terminada): static { $this->terminada = $terminada; return $this; }

    public function getMarcaTiempoMin(): ?int { return $this->marcaTiempoMin; }
    public function setMarcaTiempoMin(int $marcaTiempoMin): static { $this->marcaTiempoMin = $marcaTiempoMin; return $this; }

    public function getValoracion(): ?int { return $this->valoracion; }
    public function setValoracion(int $valoracion): static { $this->valoracion = $valoracion; return $this; }

    public function getOrigen(): ?string { return $this->origen; }
    public function setOrigen(string $origen): static { $this->origen = $origen; return $this; }

    public function getUsuario(): ?Usuario { return $this->usuario; }
    public function setUsuario(?Usuario $usuario): static { $this->usuario = $usuario; return $this; }

    public function getPelicula(): ?Pelicula { return $this->pelicula; }
    public function setPelicula(?Pelicula $pelicula): static { $this->pelicula = $pelicula; return $this; }

    public function getListaReproduccion(): ?ListaReproduccion { return $this->listaReproduccion; }
    public function setListaReproduccion(?ListaReproduccion $listaReproduccion): static { $this->listaReproduccion = $listaReproduccion; return $this; }
}
