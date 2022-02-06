<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206213806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_online TINYINT(1) NOT NULL, token VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9B1BC7E6B6 FOREIGN KEY (writer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4744FC9B1BC7E6B6 ON private_message (writer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE products');
        $this->addSql('ALTER TABLE private_message DROP FOREIGN KEY FK_4744FC9B1BC7E6B6');
        $this->addSql('DROP INDEX IDX_4744FC9B1BC7E6B6 ON private_message');
    }
}
