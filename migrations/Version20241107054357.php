<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107054357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE classe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matiere_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classe (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, niveau INT NOT NULL, effectif_actuel INT NOT NULL, effectif_max INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matiere (id INT NOT NULL, nom VARCHAR(255) NOT NULL, coefficient INT NOT NULL, nb_heure INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE classe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matiere_id_seq CASCADE');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE matiere');
    }
}
