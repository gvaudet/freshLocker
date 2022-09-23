<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220923122828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add Category, Conditioning, Stock, Cart, User and their relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, cart_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_line (product_id INT NOT NULL, cart_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_3EF1B4CF4584665A (product_id), INDEX IDX_3EF1B4CF1AD5CDBF (cart_id), PRIMARY KEY(product_id, cart_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conditioning (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_stock (product_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_EA6A2D3C4584665A (product_id), INDEX IDX_EA6A2D3CDCD6110 (stock_id), PRIMARY KEY(product_id, stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_conditioning (product_id INT NOT NULL, conditioning_id INT NOT NULL, INDEX IDX_F37DEF824584665A (product_id), INDEX IDX_F37DEF824129ED12 (conditioning_id), PRIMARY KEY(product_id, conditioning_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, external_lot_number VARCHAR(30) DEFAULT NULL, quantity INT NOT NULL, reception_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, storage_condition VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, roles JSON NOT NULL, is_enabled TINYINT(1) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3CDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_conditioning ADD CONSTRAINT FK_F37DEF824584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_conditioning ADD CONSTRAINT FK_F37DEF824129ED12 FOREIGN KEY (conditioning_id) REFERENCES conditioning (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF4584665A');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF1AD5CDBF');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C4584665A');
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3CDCD6110');
        $this->addSql('ALTER TABLE product_conditioning DROP FOREIGN KEY FK_F37DEF824584665A');
        $this->addSql('ALTER TABLE product_conditioning DROP FOREIGN KEY FK_F37DEF824129ED12');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_line');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE conditioning');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_stock');
        $this->addSql('DROP TABLE product_conditioning');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
    }
}
