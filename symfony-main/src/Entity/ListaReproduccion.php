<?php

namespace App\Entity;

use App\Repository\ListaReproduccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Lista de reproducción personalizada por el usuario (como una playlist)
#[ORM\Entity(repositoryClass: ListaReproduccionRepository::class)]
class ListaReproduccion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?\DateTime $fechaCreacion = null;

    // El usuario dueño de esta lista (muchas listas pueden pertenecer a un usuario)
    #[ORM\ManyToOne(inversedBy: 'listasReproduccion')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    // Relación ManyToMany: una lista tiene varias películas y una película puede estar en varias listas
    #[ORM\ManyToMany(targetEntity: Pelicula::class, inversedBy: 'listasReproduccion')]
    private Collection $peliculas;

    #[ORM\OneToMany(targetEntity: Visionado::class, mappedBy: 'listaReproduccion')]
    private Collection $visionados;

    public function __construct()
    {
        $this->peliculas  = new ArrayCollection();
        $this->visionados = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }

    public function getDescripcion(): ?string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): static { $this->descripcion = $descripcion; return $this; }

    public function getFechaCreacion(): ?\DateTime { return $this->fechaCreacion; }
    public function setFechaCreacion(\DateTime $fechaCreacion): static { $this->fechaCreacion = $fechaCreacion; return $this; }

    public function getUsuario(): ?Usuario { return $this->usuario; }
    public function setUsuario(?Usuario $usuario): static { $this->usuario = $usuario; return $this; }

    public function getPeliculas(): Collection { return $this->peliculas; }

    public function addPelicula(Pelicula $pelicula): static
    {
        if (!$this->peliculas->contains($pelicula)) {
            $this->peliculas->add($pelicula);
        }
        return $this;
    }

    public function removePelicula(Pelicula $pelicula): static
    {
        $this->peliculas->removeElement($pelicula);
        return $this;
    }

    public function getVisionados(): Collection { return $this->visionados; }
}
