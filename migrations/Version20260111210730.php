<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260111210730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingrediente (id INT AUTO_INCREMENT NOT NULL, receta_id INT NOT NULL, nombre VARCHAR(100) NOT NULL, cantidad DOUBLE PRECISION NOT NULL, unidad VARCHAR(20) NOT NULL, INDEX IDX_BFB4A41E54F853F8 (receta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paso (id INT AUTO_INCREMENT NOT NULL, receta_id INT NOT NULL, orden INT NOT NULL, descripcion VARCHAR(500) NOT NULL, INDEX IDX_DA71886B54F853F8 (receta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta (id INT AUTO_INCREMENT NOT NULL, tipo_id INT NOT NULL, titulo VARCHAR(100) NOT NULL, comensales INT NOT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B093494EA9276E6C (tipo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receta_nutriente (id INT AUTO_INCREMENT NOT NULL, receta_id INT NOT NULL, tipo_nutriente_id INT NOT NULL, cantidad DOUBLE PRECISION NOT NULL, INDEX IDX_5A698B7C54F853F8 (receta_id), INDEX IDX_5A698B7C1A19FC9D (tipo_nutriente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_nutriente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, unidad VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_receta (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, descripcion LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valoracion (id INT AUTO_INCREMENT NOT NULL, receta_id INT NOT NULL, puntuacion INT NOT NULL, ip VARCHAR(45) NOT NULL, INDEX IDX_6D3DE0F454F853F8 (receta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingrediente ADD CONSTRAINT FK_BFB4A41E54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE paso ADD CONSTRAINT FK_DA71886B54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE receta ADD CONSTRAINT FK_B093494EA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_receta (id)');
        $this->addSql('ALTER TABLE receta_nutriente ADD CONSTRAINT FK_5A698B7C54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE receta_nutriente ADD CONSTRAINT FK_5A698B7C1A19FC9D FOREIGN KEY (tipo_nutriente_id) REFERENCES tipo_nutriente (id)');
        $this->addSql('ALTER TABLE valoracion ADD CONSTRAINT FK_6D3DE0F454F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingrediente DROP FOREIGN KEY FK_BFB4A41E54F853F8');
        $this->addSql('ALTER TABLE paso DROP FOREIGN KEY FK_DA71886B54F853F8');
        $this->addSql('ALTER TABLE receta DROP FOREIGN KEY FK_B093494EA9276E6C');
        $this->addSql('ALTER TABLE receta_nutriente DROP FOREIGN KEY FK_5A698B7C54F853F8');
        $this->addSql('ALTER TABLE receta_nutriente DROP FOREIGN KEY FK_5A698B7C1A19FC9D');
        $this->addSql('ALTER TABLE valoracion DROP FOREIGN KEY FK_6D3DE0F454F853F8');
        $this->addSql('DROP TABLE ingrediente');
        $this->addSql('DROP TABLE paso');
        $this->addSql('DROP TABLE receta');
        $this->addSql('DROP TABLE receta_nutriente');
        $this->addSql('DROP TABLE tipo_nutriente');
        $this->addSql('DROP TABLE tipo_receta');
        $this->addSql('DROP TABLE valoracion');
    }
}
