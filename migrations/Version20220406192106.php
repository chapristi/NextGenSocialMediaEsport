<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406192106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catgeories_teams_esport (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, team_esport_id INT NOT NULL, INDEX IDX_9DB0DC4312469DE2 (category_id), INDEX IDX_9DB0DC438EA2AD33 (team_esport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catgeories_teams_esport ADD CONSTRAINT FK_9DB0DC4312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE catgeories_teams_esport ADD CONSTRAINT FK_9DB0DC438EA2AD33 FOREIGN KEY (team_esport_id) REFERENCES teams_esport (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE catgeories_teams_esport');
    }
}
