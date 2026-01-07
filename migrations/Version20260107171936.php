<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260107171936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paso ADD receta_id INT NOT NULL, ADD orden INT NOT NULL, ADD descripcion VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE paso ADD CONSTRAINT FK_DA71886B54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('CREATE INDEX IDX_DA71886B54F853F8 ON paso (receta_id)');
        $this->addSql('ALTER TABLE receta ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paso DROP FOREIGN KEY FK_DA71886B54F853F8');
        $this->addSql('DROP INDEX IDX_DA71886B54F853F8 ON paso');
        $this->addSql('ALTER TABLE paso DROP receta_id, DROP orden, DROP descripcion');
        $this->addSql('ALTER TABLE receta DROP deleted_at');
    }
}
