<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116093239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_join_team (id INT AUTO_INCREMENT NOT NULL, role JSON NOT NULL, is_validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_join_team_user (user_join_team_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_886AFCB97B05CFCC (user_join_team_id), INDEX IDX_886AFCB9A76ED395 (user_id), PRIMARY KEY(user_join_team_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_join_team_teams_esport (user_join_team_id INT NOT NULL, teams_esport_id INT NOT NULL, INDEX IDX_F31473117B05CFCC (user_join_team_id), INDEX IDX_F3147311C6647D1C (teams_esport_id), PRIMARY KEY(user_join_team_id, teams_esport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_join_team_user ADD CONSTRAINT FK_886AFCB97B05CFCC FOREIGN KEY (user_join_team_id) REFERENCES user_join_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_join_team_user ADD CONSTRAINT FK_886AFCB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_join_team_teams_esport ADD CONSTRAINT FK_F31473117B05CFCC FOREIGN KEY (user_join_team_id) REFERENCES user_join_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_join_team_teams_esport ADD CONSTRAINT FK_F3147311C6647D1C FOREIGN KEY (teams_esport_id) REFERENCES teams_esport (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_join_team_user DROP FOREIGN KEY FK_886AFCB97B05CFCC');
        $this->addSql('ALTER TABLE user_join_team_teams_esport DROP FOREIGN KEY FK_F31473117B05CFCC');
        $this->addSql('DROP TABLE user_join_team');
        $this->addSql('DROP TABLE user_join_team_user');
        $this->addSql('DROP TABLE user_join_team_teams_esport');
    }
}
