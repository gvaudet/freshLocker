<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220923141329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add Adress, FreshLocker, Locker, Order and their relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(10) DEFAULT NULL, street_name VARCHAR(120) NOT NULL, post_code VARCHAR(5) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fresh_locker (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, name VARCHAR(50) NOT NULL, serial_number VARCHAR(50) NOT NULL, INDEX IDX_9D432AA2F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locker (id INT AUTO_INCREMENT NOT NULL, fresh_locker_id INT NOT NULL, INDEX IDX_1E067DC03C0390A1 (fresh_locker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, total_price NUMERIC(10, 2) NOT NULL, order_date DATETIME NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (product_id INT NOT NULL, order_id INT NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(10, 2) NOT NULL, INDEX IDX_9CE58EE14584665A (product_id), INDEX IDX_9CE58EE18D9F6D38 (order_id), PRIMARY KEY(product_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_address (user_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_5543718BA76ED395 (user_id), INDEX IDX_5543718BF5B7AF75 (address_id), PRIMARY KEY(user_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fresh_locker ADD CONSTRAINT FK_9D432AA2F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE locker ADD CONSTRAINT FK_1E067DC03C0390A1 FOREIGN KEY (fresh_locker_id) REFERENCES fresh_locker (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7A76ED395 ON cart (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE fresh_locker DROP FOREIGN KEY FK_9D432AA2F5B7AF75');
        $this->addSql('ALTER TABLE locker DROP FOREIGN KEY FK_1E067DC03C0390A1');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE14584665A');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE18D9F6D38');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BA76ED395');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BF5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE fresh_locker');
        $this->addSql('DROP TABLE locker');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE user_address');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('DROP INDEX UNIQ_BA388B7A76ED395 ON cart');
        $this->addSql('ALTER TABLE cart DROP user_id');
    }
}
