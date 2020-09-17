<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603192117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_social (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, grupo_social_id INT NOT NULL, UNIQUE INDEX UNIQ_1433FABAA76ED395 (user_id), INDEX IDX_1433FABA14AD8027 (grupo_social_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_social (id INT AUTO_INCREMENT NOT NULL, user_admin_id INT NOT NULL, codigo_grupo VARCHAR(25) DEFAULT NULL, is_active TINYINT(1) NOT NULL, is_citas_active TINYINT(1) NOT NULL, is_contrato_active TINYINT(1) NOT NULL, contrato VARCHAR(255) DEFAULT NULL, contrato_update_at DATETIME DEFAULT NULL, INDEX IDX_7D674EBE84A66610 (user_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_social ADD CONSTRAINT FK_1433FABAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_social ADD CONSTRAINT FK_1433FABA14AD8027 FOREIGN KEY (grupo_social_id) REFERENCES grupo_social (id)');
        $this->addSql('ALTER TABLE grupo_social ADD CONSTRAINT FK_7D674EBE84A66610 FOREIGN KEY (user_admin_id) REFERENCES user_admin (id)');
        $this->addSql('DROP TABLE orla_provisional_grupos_carrera');
        $this->addSql('ALTER TABLE galeria CHANGE carpeta carpeta VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_carrera CHANGE cargo cargo VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE visualizacion_orla_grupo_carrera CHANGE fecha_visualizacion fecha_visualizacion DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera_grupo_carrera CHANGE precio precio INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resegnia CHANGE fecha_publicacion fecha_publicacion DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE proceso_orla_grupo CHANGE fecha_entrega fecha_entrega DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incidencias_carrera CHANGE incidencia incidencia VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT NULL, CHANGE numero_maximo_votar_profes numero_maximo_votar_profes INT DEFAULT NULL, CHANGE numero_maximo_votar_orlas numero_maximo_votar_orlas INT DEFAULT NULL, CHANGE contrato contrato VARCHAR(255) DEFAULT NULL, CHANGE contrato_update_at contrato_update_at DATETIME DEFAULT NULL, CHANGE numero_maximo_votar_color_becas numero_maximo_votar_color_becas INT DEFAULT NULL');
        $this->addSql('ALTER TABLE citas_fecha_cuadrante_grupo_carrera CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nombre nombre VARCHAR(100) DEFAULT NULL, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT NULL, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT NULL, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL, CHANGE mencion mencion TINYINT(1) DEFAULT NULL, CHANGE is_erasmus is_erasmus TINYINT(1) DEFAULT NULL, CHANGE fecha_registro fecha_registro DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE orlas_provisional_grupo_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE muestras_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_carrera CHANGE is_votar_citas_active is_votar_citas_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE muestras_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE color_becas_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image_gallery CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE color_becas_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_social DROP FOREIGN KEY FK_1433FABA14AD8027');
        $this->addSql('CREATE TABLE orla_provisional_grupos_carrera (id INT AUTO_INCREMENT NOT NULL, grupo_carrera_id INT NOT NULL, image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_9A40A4BCC69AF2D4 (grupo_carrera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE orla_provisional_grupos_carrera ADD CONSTRAINT FK_9A40A4BCC69AF2D4 FOREIGN KEY (grupo_carrera_id) REFERENCES grupo_carrera (id)');
        $this->addSql('DROP TABLE user_social');
        $this->addSql('DROP TABLE grupo_social');
        $this->addSql('ALTER TABLE citas_fecha_cuadrante_grupo_carrera CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE color_becas_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE color_becas_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE galeria CHANGE carpeta carpeta VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE numero_maximo_votar_profes numero_maximo_votar_profes INT DEFAULT NULL, CHANGE numero_maximo_votar_orlas numero_maximo_votar_orlas INT DEFAULT NULL, CHANGE numero_maximo_votar_color_becas numero_maximo_votar_color_becas INT DEFAULT NULL, CHANGE contrato contrato VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE contrato_update_at contrato_update_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE image_gallery CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE incidencias_carrera CHANGE incidencia incidencia VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE muestras_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE muestras_carrera_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orlas_provisional_grupo_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE update_at update_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE proceso_orla_grupo CHANGE fecha_entrega fecha_entrega DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE productos_carrera CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE productos_carrera_grupo_carrera CHANGE precio precio INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profesor_carrera CHANGE cargo cargo VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE profesor_grupo_carrera CHANGE votos votos INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resegnia CHANGE fecha_publicacion fecha_publicacion DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE nombre nombre VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE direccion direccion VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mencion mencion TINYINT(1) NOT NULL, CHANGE is_erasmus is_erasmus TINYINT(1) NOT NULL, CHANGE fecha_registro fecha_registro DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user_carrera CHANGE is_votar_citas_active is_votar_citas_active TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE visualizacion_orla_grupo_carrera CHANGE fecha_visualizacion fecha_visualizacion DATE DEFAULT \'NULL\'');
    }
}
