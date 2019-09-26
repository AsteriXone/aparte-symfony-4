<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918185811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE especialidad_carrera (id INT AUTO_INCREMENT NOT NULL, especialidad VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universidad (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grupo_carrera ADD universidad_id INT NOT NULL, ADD especialidad_carrera_id INT NOT NULL, CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE grupo_carrera ADD CONSTRAINT FK_90174397271768CD FOREIGN KEY (universidad_id) REFERENCES universidad (id)');
        $this->addSql('ALTER TABLE grupo_carrera ADD CONSTRAINT FK_901743973A3E8BCA FOREIGN KEY (especialidad_carrera_id) REFERENCES especialidad_carrera (id)');
        $this->addSql('CREATE INDEX IDX_90174397271768CD ON grupo_carrera (universidad_id)');
        $this->addSql('CREATE INDEX IDX_901743973A3E8BCA ON grupo_carrera (especialidad_carrera_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nombre nombre VARCHAR(100) DEFAULT NULL, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT NULL, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT NULL, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL, CHANGE fecha_registro fecha_registro VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grupo_carrera DROP FOREIGN KEY FK_901743973A3E8BCA');
        $this->addSql('ALTER TABLE grupo_carrera DROP FOREIGN KEY FK_90174397271768CD');
        $this->addSql('DROP TABLE especialidad_carrera');
        $this->addSql('DROP TABLE universidad');
        $this->addSql('DROP INDEX IDX_90174397271768CD ON grupo_carrera');
        $this->addSql('DROP INDEX IDX_901743973A3E8BCA ON grupo_carrera');
        $this->addSql('ALTER TABLE grupo_carrera DROP universidad_id, DROP especialidad_carrera_id, CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE nombre nombre VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apellido_1 apellido_1 VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apellido_2 apellido_2 VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE direccion direccion VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE fecha_registro fecha_registro VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
