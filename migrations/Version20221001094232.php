<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221001094232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'clear Product and Conditioning for change';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE conditioning DROP name');
        $this->addSql('ALTER TABLE product DROP description, DROP photo, DROP unit_price, DROP name, DROP conversion_factor');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE conditioning ADD name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE product ADD description LONGTEXT DEFAULT NULL, ADD photo VARCHAR(50) DEFAULT NULL, ADD unit_price NUMERIC(6, 2) NOT NULL, ADD name VARCHAR(50) NOT NULL, ADD conversion_factor VARCHAR(50) NOT NULL');
    }
}
