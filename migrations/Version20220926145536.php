<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220926145536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add field phone_numer in User';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP phone_number');
    }
}
