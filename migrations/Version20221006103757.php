<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221006103757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add total field to OrderLine Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_line ADD total DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_line DROP total');
    }
}
