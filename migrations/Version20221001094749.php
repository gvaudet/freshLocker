<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221001094749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change Product and Conditioning';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE conditioning ADD label VARCHAR(50) NOT NULL, ADD conversion_factor DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product ADD label VARCHAR(50) NOT NULL, ADD unit_price NUMERIC(6, 2) NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD photo VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE conditioning DROP label, DROP conversion_factor');
        $this->addSql('ALTER TABLE product DROP label, DROP unit_price, DROP description, DROP photo');
    }
}
