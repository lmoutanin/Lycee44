<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209111022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD classe_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E38F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_717E22E38F5EA509 ON etudiant (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E38F5EA509');
        $this->addSql('DROP INDEX IDX_717E22E38F5EA509');
        $this->addSql('ALTER TABLE etudiant DROP classe_id');
    }
}
