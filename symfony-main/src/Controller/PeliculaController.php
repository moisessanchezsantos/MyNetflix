<?php

namespace App\Controller;

use App\Entity\Pelicula;
use App\Repository\PeliculaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;

// Controlador principal: gestiona el catálogo de películas (listar, reproducir, subir y borrar)
final class PeliculaController extends AbstractController
{
    // Página principal: obtiene todas las películas de la BD y las pasa a la vista
    #[Route('/', name: 'app_movies')]
    public function index(PeliculaRepository $peliculaRepository): Response
    {
        $peliculas = $peliculaRepository->findAll();
        return $this->render('pelicula/index.html.twig', [
            'peliculas' => $peliculas,
        ]);
    }

    // Sirve el archivo de vídeo directamente desde PHP (evita que sea accesible sin pasar por aquí)
    #[Route('/pelicula/{fileName}/play', name: 'play_movie', methods: ['GET'])]
    public function playMovie(string $fileName): Response
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/pelis/' . $fileName;

        if (!file_exists($filePath)) {
            return new Response('Archivo no encontrado', 404);
        }

        return new BinaryFileResponse($filePath);
    }

    // Recibe el formulario de subida: valida los archivos, los mueve a /public y guarda la película en la BD
    #[Route('/upload', name: 'app_movie_upload', methods: ['POST'])]
    public function upload(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $videoFile   = $request->files->get('movieFile');
        $portadaFile = $request->files->get('portadaFile');
        $titulo      = $request->request->get('titulo');

        // Comprobamos que el usuario haya seleccionado ambos archivos
        if (!$videoFile || !$portadaFile) {
            $this->addFlash('error', 'Debes seleccionar el vídeo y la portada.');
            return $this->redirectToRoute('app_movies');
        }

        // Comprobamos errores de subida (tamaño, permisos, etc.)
        if ($videoFile->getError() !== UPLOAD_ERR_OK || $portadaFile->getError() !== UPLOAD_ERR_OK) {
            $code = $videoFile->getError() !== UPLOAD_ERR_OK ? $videoFile->getError() : $portadaFile->getError();
            $msg  = 'Error en la subida (código ' . $code . ').';
            if ($code === 1) $msg .= ' El archivo supera el límite de php.ini.';
            $this->addFlash('error', $msg);
            return $this->redirectToRoute('app_movies');
        }

        // Detectamos la extensión real del archivo (guessExtension usa el MIME type)
        $extVideo   = $videoFile->guessExtension()   ?? 'mp4';
        $extPortada = $portadaFile->guessExtension()  ?? 'jpg';

        // El slugger limpia el nombre (quita tildes, espacios…) y añadimos un ID único para evitar colisiones
        $newVideo   = $slugger->slug(pathinfo($videoFile->getClientOriginalName(),   PATHINFO_FILENAME)) . '-' . uniqid() . '.' . $extVideo;
        $newPortada = $slugger->slug(pathinfo($portadaFile->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . uniqid() . '.' . $extPortada;

        try {
            // Creamos la entidad y rellenamos sus campos con los datos del formulario
            $pelicula = new Pelicula();
            $pelicula->setTitulo($titulo);
            $pelicula->setRutaArchivo($newVideo);
            $pelicula->setPortadaURL('/portadas/' . $newPortada);
            $pelicula->setDescripcion($request->request->get('descripcion', 'Sin descripción.'));
            $pelicula->setDuracionMin((int) $request->request->get('duracion', 90));
            $pelicula->setFechaEstreno(new \DateTime());
            $pelicula->setPais('España');
            $pelicula->setClasificacionEdad('7+');
            $pelicula->setFormatoVideo($extVideo);
            $pelicula->setAudios([]);
            $pelicula->setSubtitulos([]);
            $pelicula->setGeneros([]);

            // Movemos los archivos a sus carpetas dentro de /public
            $videoFile->move(  $this->getParameter('kernel.project_dir') . '/public/pelis',    $newVideo);
            $portadaFile->move($this->getParameter('kernel.project_dir') . '/public/portadas', $newPortada);

            // persist() prepara el objeto; flush() ejecuta el INSERT en la base de datos
            $em->persist($pelicula);
            $em->flush();

            $this->addFlash('success', '¡"' . $titulo . '" añadida al catálogo!');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error al guardar: ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_movies');
    }

    // Elimina la película de la BD y borra también los archivos físicos del servidor
    #[Route('/pelicula/{id}/eliminar', name: 'app_movie_delete', methods: ['POST'])]
    public function delete(int $id, PeliculaRepository $repo, EntityManagerInterface $em): Response
    {
        $pelicula = $repo->find($id);
        if ($pelicula) {
            $dir = $this->getParameter('kernel.project_dir') . '/public';
            // @ suprime el error si el archivo ya no existe en disco
            @unlink($dir . '/pelis/'    . $pelicula->getRutaArchivo());
            @unlink($dir . $pelicula->getPortadaURL());
            $em->remove($pelicula);
            $em->flush();
            $this->addFlash('success', 'Película eliminada.');
        }
        return $this->redirectToRoute('app_movies');
    }
}
