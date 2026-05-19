<?php

namespace App\Entity;

use App\Repository\PeliculaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Entidad que representa una película del catálogo
#[ORM\Entity(repositoryClass: PeliculaRepository::class)]
class Pelicula
{
    // ID auto-incremental generado por la base de datos
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    // TEXT en vez de VARCHAR porque la sinopsis puede ser larga
    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?int $duracionMin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fechaEstreno = null;

    #[ORM\Column(length: 255)]
    private ?string $pais = null;

    #[ORM\Column(length: 255)]
    private ?string $clasificacionEdad = null;

    // Ruta relativa a la imagen de portada, p.ej. /portadas/nombre.jpg
    #[ORM\Column(length: 255)]
    private ?string $portadaURL = null;

    // Arrays JSON: idiomas de audio disponibles
    #[ORM\Column]
    private array $audios = [];

    // Arrays JSON: idiomas de subtítulos disponibles
    #[ORM\Column]
    private array $subtitulos = [];

    #[ORM\Column]
    private array $generos = [];

    // Nombre del archivo de vídeo guardado en /public/pelis/
    #[ORM\Column(length: 255)]
    private ?string $rutaArchivo = null;

    #[ORM\Column(length: 255)]
    private ?string $formatoVideo = null;

    // Campo transitorio (no persiste en BD) para subir el video desde EasyAdmin
    private ?string $videoUpload = null;

    // Una película puede estar en muchas listas de reproducción
    #[ORM\ManyToMany(targetEntity: ListaReproduccion::class, mappedBy: 'peliculas')]
    private Collection $listasReproduccion;

    // Una película puede tener muchos visionados (historial)
    #[ORM\OneToMany(targetEntity: Visionado::class, mappedBy: 'pelicula')]
    private Collection $visionados;

    public function __construct()
    {
        $this->listasReproduccion = new ArrayCollection();
        $this->visionados = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitulo(): ?string { return $this->titulo; }
    public function setTitulo(string $titulo): static { $this->titulo = $titulo; return $this; }

    public function getDescripcion(): ?string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): static { $this->descripcion = $descripcion; return $this; }

    public function getDuracionMin(): ?int { return $this->duracionMin; }
    public function setDuracionMin(int $duracionMin): static { $this->duracionMin = $duracionMin; return $this; }

    public function getFechaEstreno(): ?\DateTime { return $this->fechaEstreno; }
    public function setFechaEstreno(\DateTime $fechaEstreno): static { $this->fechaEstreno = $fechaEstreno; return $this; }

    public function getPais(): ?string { return $this->pais; }
    public function setPais(string $pais): static { $this->pais = $pais; return $this; }

    public function getClasificacionEdad(): ?string { return $this->clasificacionEdad; }
    public function setClasificacionEdad(string $clasificacionEdad): static { $this->clasificacionEdad = $clasificacionEdad; return $this; }

    public function getPortadaURL(): ?string { return $this->portadaURL; }
    public function setPortadaURL(string $portadaURL): static { $this->portadaURL = $portadaURL; return $this; }

    public function getAudios(): array { return $this->audios; }
    public function setAudios(array $audios): static { $this->audios = $audios; return $this; }

    public function getSubtitulos(): array { return $this->subtitulos; }
    public function setSubtitulos(array $subtitulos): static { $this->subtitulos = $subtitulos; return $this; }

    public function getGeneros(): array { return $this->generos; }
    public function setGeneros(array $generos): static { $this->generos = $generos; return $this; }

    public function getRutaArchivo(): ?string { return $this->rutaArchivo; }
    public function setRutaArchivo(string $rutaArchivo): static { $this->rutaArchivo = $rutaArchivo; return $this; }

    public function getVideoUpload(): ?string { return $this->videoUpload; }
    public function setVideoUpload(?string $videoUpload): static { $this->videoUpload = $videoUpload; return $this; }

    public function getFormatoVideo(): ?string { return $this->formatoVideo; }
    public function setFormatoVideo(string $formatoVideo): static { $this->formatoVideo = $formatoVideo; return $this; }

    public function getListasReproduccion(): Collection { return $this->listasReproduccion; }
    public function getVisionados(): Collection { return $this->visionados; }
}
