<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190916201655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD nombre VARCHAR(100) DEFAULT NULL, ADD apellido_1 VARCHAR(100) DEFAULT NULL, ADD apellido_2 VARCHAR(100) DEFAULT NULL, ADD direccion VARCHAR(255) DEFAULT NULL, ADD telefono VARCHAR(20) NOT NULL, ADD mencion TINYINT(1) NOT NULL, ADD is_erasmus TINYINT(1) NOT NULL, ADD fecha_registro VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grupo_carrera CHANGE codigo_grupo codigo_grupo VARCHAR(25) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user DROP nombre, DROP apellido_1, DROP apellido_2, DROP direccion, DROP telefono, DROP mencion, DROP is_erasmus, DROP fecha_registro, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
