<?php

namespace App\Controller\Admin;

use App\Entity\Pelicula;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PeliculaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pelicula::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titulo', 'Titulo'),
            TextField::new('descripcion', 'Descripcion'),
            IntegerField::new('duracionMin', 'Duracion (min)'),
            DateField::new('fechaEstreno', 'Fecha de Estreno'),
            TextField::new('pais', 'Pais'),
            TextField::new('clasificacionEdad', 'Clasificacion de Edad'),
            ImageField::new('portadaURL', 'Portada (imagen)')
                ->setUploadDir('public/portadas')
                ->setBasePath('portadas')
                ->setUploadedFileNamePattern('[originalname]')
                ->setRequired(false),
            ImageField::new('videoUpload', 'Video (subir archivo)')
                ->setUploadDir('public/pelis')
                ->setBasePath('pelis')
                ->setUploadedFileNamePattern('[originalname]')
                ->setRequired(false)
                ->hideOnIndex()
                ->setFormTypeOptions([
                    'attr' => ['accept' => 'video/*,.mp4,.mkv,.avi,.webm,.mov'],
                    'constraints' => [],
                ]),
            TextField::new('rutaArchivo', 'Video actual')
                ->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->fixPaths($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->fixPaths($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function fixPaths(Pelicula $pelicula): void
    {
        // ImageField almacena solo el nombre; añadimos el prefijo de ruta completa
        $portada = $pelicula->getPortadaURL();
        if ($portada !== null && $portada !== '' && !str_starts_with($portada, '/')) {
            $pelicula->setPortadaURL('/portadas/' . $portada);
        }

        // El video se sube al campo transitorio videoUpload; lo movemos a rutaArchivo
        $video = $pelicula->getVideoUpload();
        if ($video !== null && $video !== '') {
            if (!str_starts_with($video, '/')) {
                $video = '/pelis/' . $video;
            }
            $pelicula->setRutaArchivo($video);
            // Detectar formato automáticamente
            $ext = pathinfo($video, PATHINFO_EXTENSION);
            if ($ext) {
                $pelicula->setFormatoVideo(strtolower($ext));
            }
            $pelicula->setVideoUpload(null);
        }
    }
}

