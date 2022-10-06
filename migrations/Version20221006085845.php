<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20221006085845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add billingAddress and freshlocker fields in Order Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` ADD billing_address LONGTEXT NOT NULL, ADD fresh_locker LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` DROP billing_address, DROP fresh_locker');
    }
}
