<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202203143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ask_user_join_team (id INT AUTO_INCREMENT NOT NULL, teams_id INT NOT NULL, user_asked_id INT NOT NULL, users_id INT NOT NULL, is_accepted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_65C4BA3BD6365F12 (teams_id), INDEX IDX_65C4BA3B5ACB2A28 (user_asked_id), INDEX IDX_65C4BA3B67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ask_user_join_team ADD CONSTRAINT FK_65C4BA3BD6365F12 FOREIGN KEY (teams_id) REFERENCES teams_esport (id)');
        $this->addSql('ALTER TABLE ask_user_join_team ADD CONSTRAINT FK_65C4BA3B5ACB2A28 FOREIGN KEY (user_asked_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ask_user_join_team ADD CONSTRAINT FK_65C4BA3B67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ask_user_join_team');
    }
}
