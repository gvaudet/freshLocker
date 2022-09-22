<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220922145509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change fields in english';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product ADD name VARCHAR(50) NOT NULL, ADD conversion_factor VARCHAR(50) NOT NULL, DROP libelle, DROP facteur_de_conversion, CHANGE prix_unitaire unit_price NUMERIC(6, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product ADD libelle VARCHAR(50) NOT NULL, ADD facteur_de_conversion VARCHAR(50) NOT NULL, DROP name, DROP conversion_factor, CHANGE unit_price prix_unitaire NUMERIC(6, 2) NOT NULL');
    }
}
