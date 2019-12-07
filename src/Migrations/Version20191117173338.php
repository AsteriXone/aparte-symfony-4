<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117173338 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE votaciones_color_beca_carrera (id INT AUTO_INCREMENT NOT NULL, user_carrera_id INT NOT NULL, color_beca_carrera_id INT NOT NULL, INDEX IDX_E2C1A168611672E3 (user_carrera_id), INDEX IDX_E2C1A1684AD7CEAE (color_beca_carrera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_becas_carrera_grupo_carrera (id INT AUTO_INCREMENT NOT NULL, color_becas_carrera_id INT NOT NULL, grupo_carrera_id INT NOT NULL, votos INT DEFAULT NULL, INDEX IDX_96D5E5D6195CE70A (color_becas_carrera_id), INDEX IDX_96D5E5D6C69AF2D4 (grupo_carrera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_becas_carrera (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, update_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE votaciones_color_beca_carrera ADD CONSTRAINT FK_E2C1A168611672E3 FOREIGN KEY (user_carrera_id) REFERENCES user_carrera (id)');
        $this->addSql('ALTER TABLE votaciones_color_beca_carrera ADD CONSTRAINT FK_E2C1A1684AD7CEAE FOREIGN KEY (color_beca_carrera_id) REFERENCES color_becas_carrera (id)');
        $this->addSql('ALTER TABLE color_becas_carrera_grupo_carrera ADD CONSTRAINT FK_96D5E5D6195CE70A FOREIGN KEY (color_becas_carrera_id) REFERENCES color_becas_carrera (id)');
        $this->addSql('ALTER TABLE color_becas_carrera_grupo_carrera ADD CONSTRAINT FK_96D5E5D6C69AF2D4 FOREIGN KEY (grupo_carrera_id) REFERENCES grupo_carrera (id)');
        $this->addSql('ALTER TABLE galeria CHANGE carpeta carpeta VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_carrera CHANGE cargo cargo VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera_grupo_carrera CHANGE precio precio INT DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT NULL, CHANGE numero_maximo_votar_profes numero_maximo_votar_profes INT DEFAULT NULL, CHANGE numero_maximo_votar_orlas numero_maximo_votar_orlas INT DEFAULT NULL, CHANGE contrato_update_at contrato_update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE citas_fecha_cuadrante_grupo_carrera CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nombre nombre VARCHAR(100) DEFAULT NULL, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT NULL, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT NULL, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL, CHANGE fecha_registro fecha_registro DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE muestras_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE muestras_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE image_gallery CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE votaciones_color_beca_carrera DROP FOREIGN KEY FK_E2C1A1684AD7CEAE');
        $this->addSql('ALTER TABLE color_becas_carrera_grupo_carrera DROP FOREIGN KEY FK_96D5E5D6195CE70A');
        $this->addSql('DROP TABLE votaciones_color_beca_carrera');
        $this->addSql('DROP TABLE color_becas_carrera_grupo_carrera');
        $this->addSql('DROP TABLE color_becas_carrera');
        $this->addSql('ALTER TABLE citas_fecha_cuadrante_grupo_carrera CHANGE usuario_id usuario_id INT DEFAULT NULL');
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
