<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191103100113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fecha_cuadrante_grupo_carrera (id INT AUTO_INCREMENT NOT NULL, cuadrante_id INT NOT NULL, fecha DATE NOT NULL, INDEX IDX_2F5BE317FC26DB4A (cuadrante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fecha_cuadrante_grupo_carrera ADD CONSTRAINT FK_2F5BE317FC26DB4A FOREIGN KEY (cuadrante_id) REFERENCES cuadrantes (id)');
        $this->addSql('ALTER TABLE galeria CHANGE carpeta carpeta VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_carrera CHANGE cargo cargo VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera_grupo_carrera CHANGE precio precio INT DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT NULL, CHANGE numero_maximo_votar_profes numero_maximo_votar_profes INT DEFAULT NULL, CHANGE numero_maximo_votar_orlas numero_maximo_votar_orlas INT DEFAULT NULL, CHANGE contrato_update_at contrato_update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nombre nombre VARCHAR(100) DEFAULT NULL, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT NULL, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT NULL, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL, CHANGE fecha_registro fecha_registro DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE muestras_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE muestras_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE image_gallery CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fecha_cuadrante_grupo_carrera');
        $this->addSql('ALTER TABLE galeria CHANGE carpeta carpeta VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE numero_maximo_votar_profes numero_maximo_votar_profes INT DEFAULT NULL, CHANGE numero_maximo_votar_orlas numero_maximo_votar_orlas INT DEFAULT NULL, CHANGE contrato_update_at contrato_update_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE image_gallery CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE muestras_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE muestras_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE productos_carrera_grupo_carrera CHANGE precio precio INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_carrera CHANGE cargo cargo VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE profesor_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE nombre nombre VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE direccion direccion VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE fecha_registro fecha_registro DATETIME DEFAULT \'NULL\'');
    }
}
