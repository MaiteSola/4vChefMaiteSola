<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260108180030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receta_nutriente DROP FOREIGN KEY FK_5A698B7CA94AA29D');
        $this->addSql('DROP INDEX IDX_5A698B7CA94AA29D ON receta_nutriente');
        $this->addSql('ALTER TABLE receta_nutriente CHANGE nutriente_id tipo_nutriente_id INT NOT NULL');
        $this->addSql('ALTER TABLE receta_nutriente ADD CONSTRAINT FK_5A698B7C1A19FC9D FOREIGN KEY (tipo_nutriente_id) REFERENCES tipo_nutriente (id)');
        $this->addSql('CREATE INDEX IDX_5A698B7C1A19FC9D ON receta_nutriente (tipo_nutriente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receta_nutriente DROP FOREIGN KEY FK_5A698B7C1A19FC9D');
        $this->addSql('DROP INDEX IDX_5A698B7C1A19FC9D ON receta_nutriente');
        $this->addSql('ALTER TABLE receta_nutriente CHANGE tipo_nutriente_id nutriente_id INT NOT NULL');
        $this->addSql('ALTER TABLE receta_nutriente ADD CONSTRAINT FK_5A698B7CA94AA29D FOREIGN KEY (nutriente_id) REFERENCES tipo_nutriente (id)');
        $this->addSql('CREATE INDEX IDX_5A698B7CA94AA29D ON receta_nutriente (nutriente_id)');
    }
}
