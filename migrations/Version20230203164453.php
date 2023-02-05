<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203164453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_coding_language (user_id INT NOT NULL, coding_language_id INT NOT NULL, INDEX IDX_1A3F1F30A76ED395 (user_id), INDEX IDX_1A3F1F309552E5E2 (coding_language_id), PRIMARY KEY(user_id, coding_language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_coding_language ADD CONSTRAINT FK_1A3F1F30A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_coding_language ADD CONSTRAINT FK_1A3F1F309552E5E2 FOREIGN KEY (coding_language_id) REFERENCES coding_language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE freelance ADD picture VARCHAR(255) DEFAULT NULL, ADD biographie LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP profil_picture, DROP cover_picture, DROP description, DROP phone');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_coding_language DROP FOREIGN KEY FK_1A3F1F30A76ED395');
        $this->addSql('ALTER TABLE user_coding_language DROP FOREIGN KEY FK_1A3F1F309552E5E2');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user_coding_language');
        $this->addSql('ALTER TABLE freelance DROP picture, DROP biographie');
        $this->addSql('ALTER TABLE `user` ADD profil_picture VARCHAR(255) DEFAULT NULL, ADD cover_picture VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(20) DEFAULT NULL');
    }
}
