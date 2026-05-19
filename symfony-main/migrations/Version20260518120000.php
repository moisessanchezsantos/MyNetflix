<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260518120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Eliminar tablas de suscripción (no se usan)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE suscripcion_pelicula DROP FOREIGN KEY FK_1D3B048F189E045D');
        $this->addSql('ALTER TABLE suscripcion_pelicula DROP FOREIGN KEY FK_1D3B048F70713909');
        $this->addSql('ALTER TABLE suscripcion DROP FOREIGN KEY FK_497FA0DB38439E');
        $this->addSql('DROP TABLE suscripcion_pelicula');
        $this->addSql('DROP TABLE suscripcion');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE suscripcion (id INT AUTO_INCREMENT NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, precio_mensual NUMERIC(10, 0) NOT NULL, tipo_plan VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, usuario_id INT NOT NULL, INDEX IDX_497FA0DB38439E (usuario_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE suscripcion_pelicula (suscripcion_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_1D3B048F189E045D (suscripcion_id), INDEX IDX_1D3B048F70713909 (pelicula_id), PRIMARY KEY (suscripcion_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE suscripcion ADD CONSTRAINT FK_497FA0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE suscripcion_pelicula ADD CONSTRAINT FK_1D3B048F189E045D FOREIGN KEY (suscripcion_id) REFERENCES suscripcion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suscripcion_pelicula ADD CONSTRAINT FK_1D3B048F70713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
    }
}
