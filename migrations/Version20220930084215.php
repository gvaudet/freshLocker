<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220930084215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Producer Entity and relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT NOT NULL, label VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_976449DCA76ED395 (user_id), INDEX IDX_976449DC4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DC4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DCA76ED395');
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DC4584665A');
        $this->addSql('DROP TABLE producer');
    }
}
