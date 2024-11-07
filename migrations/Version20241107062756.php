<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107062756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence_matiere (absence_id INT NOT NULL, matiere_id INT NOT NULL, PRIMARY KEY(absence_id, matiere_id))');
        $this->addSql('CREATE INDEX IDX_599272C22DFF238F ON absence_matiere (absence_id)');
        $this->addSql('CREATE INDEX IDX_599272C2F46CD258 ON absence_matiere (matiere_id)');
        $this->addSql('ALTER TABLE absence_matiere ADD CONSTRAINT FK_599272C22DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE absence_matiere ADD CONSTRAINT FK_599272C2F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE absence_matiere DROP CONSTRAINT FK_599272C22DFF238F');
        $this->addSql('ALTER TABLE absence_matiere DROP CONSTRAINT FK_599272C2F46CD258');
        $this->addSql('DROP TABLE absence_matiere');
    }
}
