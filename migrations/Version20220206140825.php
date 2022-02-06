<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206140825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_join_team_user DROP FOREIGN KEY FK_886AFCB97B05CFCC');
        $this->addSql('ALTER TABLE user_join_team_user ADD CONSTRAINT FK_886AFCB97B05CFCC FOREIGN KEY (user_join_team_id) REFERENCES user_join_team (id)');
        $this->addSql('ALTER TABLE user_join_team_teams_esport DROP FOREIGN KEY FK_F31473117B05CFCC');
        $this->addSql('ALTER TABLE user_join_team_teams_esport ADD CONSTRAINT FK_F31473117B05CFCC FOREIGN KEY (user_join_team_id) REFERENCES user_join_team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_join_team_teams_esport DROP FOREIGN KEY FK_F31473117B05CFCC');
        $this->addSql('ALTER TABLE user_join_team_teams_esport ADD CONSTRAINT FK_F31473117B05CFCC FOREIGN KEY (user_join_team_id) REFERENCES user_join_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_join_team_user DROP FOREIGN KEY FK_886AFCB97B05CFCC');
        $this->addSql('ALTER TABLE user_join_team_user ADD CONSTRAINT FK_886AFCB97B05CFCC FOREIGN KEY (user_join_team_id) REFERENCES user_join_team (id) ON DELETE CASCADE');
    }
}
