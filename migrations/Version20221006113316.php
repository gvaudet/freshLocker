<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20221006113316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add productName in OrderLine Field Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_line ADD product_label VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_line DROP product_label');
    }
}
