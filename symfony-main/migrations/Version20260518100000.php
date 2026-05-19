<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260518100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Schema inicial NetflixMoi';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE lista_reproduccion (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, fecha_creacion DATETIME NOT NULL, usuario_id INT NOT NULL, INDEX IDX_DF870A5ADB38439E (usuario_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE lista_reproduccion_pelicula (lista_reproduccion_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_851998538E599080 (lista_reproduccion_id), INDEX IDX_8519985370713909 (pelicula_id), PRIMARY KEY (lista_reproduccion_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pelicula (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, duracion_min INT NOT NULL, fecha_estreno DATE NOT NULL, pais VARCHAR(255) NOT NULL, clasificacion_edad VARCHAR(255) NOT NULL, portada_url VARCHAR(255) NOT NULL, audios JSON NOT NULL, subtitulos JSON NOT NULL, generos JSON NOT NULL, ruta_archivo VARCHAR(255) NOT NULL, formato_video VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE suscripcion (id INT AUTO_INCREMENT NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, precio_mensual NUMERIC(10, 0) NOT NULL, tipo_plan VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, usuario_id INT NOT NULL, INDEX IDX_497FA0DB38439E (usuario_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE suscripcion_pelicula (suscripcion_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_1D3B048F189E045D (suscripcion_id), INDEX IDX_1D3B048F70713909 (pelicula_id), PRIMARY KEY (suscripcion_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_registro DATETIME NOT NULL, metodo_pago_enmascarado VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, metodo_pago_tipo VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE visionado (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, terminada TINYINT NOT NULL, marca_tiempo_min INT NOT NULL, valoracion INT NOT NULL, origen VARCHAR(255) NOT NULL, usuario_id INT NOT NULL, pelicula_id INT NOT NULL, lista_reproduccion_id INT DEFAULT NULL, INDEX IDX_D7D9294DB38439E (usuario_id), INDEX IDX_D7D929470713909 (pelicula_id), INDEX IDX_D7D92948E599080 (lista_reproduccion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE lista_reproduccion ADD CONSTRAINT FK_DF870A5ADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE lista_reproduccion_pelicula ADD CONSTRAINT FK_851998538E599080 FOREIGN KEY (lista_reproduccion_id) REFERENCES lista_reproduccion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista_reproduccion_pelicula ADD CONSTRAINT FK_8519985370713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suscripcion ADD CONSTRAINT FK_497FA0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE suscripcion_pelicula ADD CONSTRAINT FK_1D3B048F189E045D FOREIGN KEY (suscripcion_id) REFERENCES suscripcion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suscripcion_pelicula ADD CONSTRAINT FK_1D3B048F70713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visionado ADD CONSTRAINT FK_D7D9294DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE visionado ADD CONSTRAINT FK_D7D929470713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id)');
        $this->addSql('ALTER TABLE visionado ADD CONSTRAINT FK_D7D92948E599080 FOREIGN KEY (lista_reproduccion_id) REFERENCES lista_reproduccion (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lista_reproduccion DROP FOREIGN KEY FK_DF870A5ADB38439E');
        $this->addSql('ALTER TABLE lista_reproduccion_pelicula DROP FOREIGN KEY FK_851998538E599080');
        $this->addSql('ALTER TABLE lista_reproduccion_pelicula DROP FOREIGN KEY FK_8519985370713909');
        $this->addSql('ALTER TABLE suscripcion DROP FOREIGN KEY FK_497FA0DB38439E');
        $this->addSql('ALTER TABLE suscripcion_pelicula DROP FOREIGN KEY FK_1D3B048F189E045D');
        $this->addSql('ALTER TABLE suscripcion_pelicula DROP FOREIGN KEY FK_1D3B048F70713909');
        $this->addSql('ALTER TABLE visionado DROP FOREIGN KEY FK_D7D9294DB38439E');
        $this->addSql('ALTER TABLE visionado DROP FOREIGN KEY FK_D7D929470713909');
        $this->addSql('ALTER TABLE visionado ADD CONSTRAINT FK_D7D92948E599080 FOREIGN KEY (lista_reproduccion_id) REFERENCES lista_reproduccion (id)');
        $this->addSql('DROP TABLE lista_reproduccion');
        $this->addSql('DROP TABLE lista_reproduccion_pelicula');
        $this->addSql('DROP TABLE pelicula');
        $this->addSql('DROP TABLE suscripcion');
        $this->addSql('DROP TABLE suscripcion_pelicula');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE visionado');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
