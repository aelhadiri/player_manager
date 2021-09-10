<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909164942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, manager_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, INDEX IDX_B8EE3872783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, birth_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistic (id INT AUTO_INCREMENT NOT NULL, team_player_id INT NOT NULL, played_games INT NOT NULL, played_minutes INT NOT NULL, number_of_assists INT NOT NULL, number_of_goals INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_649B469C2EE3EB38 (team_player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, level VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C4E0A61F61190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_player (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, team_id INT DEFAULT NULL, season YEAR, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EE023DBC99E6F5DF (player_id), INDEX IDX_EE023DBC296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE3872783E3463 FOREIGN KEY (manager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469C2EE3EB38 FOREIGN KEY (team_player_id) REFERENCES team_player (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE team_player ADD CONSTRAINT FK_EE023DBC99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE team_player ADD CONSTRAINT FK_EE023DBC296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F61190A32');
        $this->addSql('ALTER TABLE team_player DROP FOREIGN KEY FK_EE023DBC99E6F5DF');
        $this->addSql('ALTER TABLE team_player DROP FOREIGN KEY FK_EE023DBC296CD8AE');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469C2EE3EB38');
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE3872783E3463');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE statistic');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_player');
        $this->addSql('DROP TABLE user');
    }
}
