# MyNetflix

Aplicación web de catálogo y reproducción de películas, desarrollada como proyecto académico con Symfony y PHP. Incluye una parte pública para consultar películas y un área de administración para gestionar el catálogo.

## Funcionalidades

- Catálogo de películas con portada, descripción, duración, país y clasificación.
- Reproducción de vídeos almacenados localmente.
- Gestión de películas desde EasyAdmin.
- Entidades para usuarios, películas, listas de reproducción y visionados.
- Persistencia de datos con Doctrine ORM y MySQL.
- Migraciones de base de datos.
- Interfaz construida con Twig, CSS y JavaScript.

## Tecnologías

- PHP 8.2 o superior
- Symfony 7.4
- Doctrine ORM
- MySQL 8 o MariaDB
- EasyAdmin y Twig
- Symfony AssetMapper, Stimulus y Turbo
- HTML5, CSS3 y JavaScript

## Instalación

Requisitos: PHP 8.2+, Composer y MySQL/MariaDB. Docker Compose es opcional.

```bash
cd symfony-main
composer install
cp .env.example .env
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start
```

En Windows, copia `.env.example` y renómbralo como `.env` si `cp` no está disponible.

Para iniciar la base de datos con Docker:

```bash
cd symfony-main
docker compose up -d
```

## Estructura

```text
.
├── symfony-main/
│   ├── assets/          # JavaScript y estilos
│   ├── config/          # Configuración de Symfony
│   ├── migrations/      # Migraciones de la base de datos
│   ├── public/          # Punto de entrada y recursos públicos
│   ├── src/             # Controladores, entidades y repositorios
│   ├── templates/       # Plantillas Twig
│   ├── compose.yaml     # Servicio MySQL para desarrollo
│   ├── composer.json
│   └── .env.example
└── README.md
```

## Publicación

MyNetflix necesita PHP, Symfony y una base de datos, por lo que no es una web estática para Vercel. Para ejecutarlo en línea hay que utilizar un servicio que admita aplicaciones PHP y MySQL, o separar el frontend de la aplicación y consumir una API.

## Estado del proyecto

Proyecto académico en evolución. La configuración está pensada para desarrollo local y debe revisarse antes de usarla en producción, especialmente la autenticación, los permisos y la gestión de archivos multimedia.

## Autor

Moisés Sánchez Santos  
[GitHub](https://github.com/moisessanchezsantos)