<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116130224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coding_language (id INT AUTO_INCREMENT NOT NULL, name_coding_language VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coding_language_freelance (coding_language_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_8D5424299552E5E2 (coding_language_id), INDEX IDX_8D542429E8DF656B (freelance_id), PRIMARY KEY(coding_language_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `database` (id INT AUTO_INCREMENT NOT NULL, name_database VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE database_freelance (database_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_A59503FCF0AA09DB (database_id), INDEX IDX_A59503FCE8DF656B (freelance_id), PRIMARY KEY(database_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE framework (id INT AUTO_INCREMENT NOT NULL, name_framework VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE framework_freelance (framework_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_AE0D189737AECF72 (framework_id), INDEX IDX_AE0D1897E8DF656B (freelance_id), PRIMARY KEY(framework_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freelance (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, price INT NOT NULL, duration_preference VARCHAR(255) DEFAULT NULL, remote_work VARCHAR(255) DEFAULT NULL, xp_years VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, content LONGTEXT DEFAULT NULL, datetime DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE methodology (id INT AUTO_INCREMENT NOT NULL, name_methodology VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE methodology_freelance (methodology_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_115C1D5ED22DC3B (methodology_id), INDEX IDX_115C1D5EE8DF656B (freelance_id), PRIMARY KEY(methodology_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, send_mission_id INT DEFAULT NULL, receive_mission_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, object VARCHAR(255) DEFAULT NULL, start_date DATE NOT NULL, is_read TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, add_file VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, frenquency VARCHAR(255) DEFAULT NULL, INDEX IDX_9067F23CA16D3CEB (send_mission_id), INDEX IDX_9067F23C73176E35 (receive_mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinion (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, freelance_id INT DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, date_opinion DATE DEFAULT NULL, star INT DEFAULT NULL, INDEX IDX_AB02B02767B3B43D (users_id), INDEX IDX_AB02B027E8DF656B (freelance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE path (id INT AUTO_INCREMENT NOT NULL, freelance_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_B548B0FE8DF656B (freelance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name_plateform VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform_freelance (platform_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_BB97C73DFFE6496F (platform_id), INDEX IDX_BB97C73DE8DF656B (freelance_id), PRIMARY KEY(platform_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professionnal (id INT AUTO_INCREMENT NOT NULL, post VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, diploma_title VARCHAR(50) DEFAULT NULL, school_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_7161E187CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spoken_language (id INT AUTO_INCREMENT NOT NULL, name_language VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spoken_language_freelance (spoken_language_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_B761A24950D2B87B (spoken_language_id), INDEX IDX_B761A249E8DF656B (freelance_id), PRIMARY KEY(spoken_language_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, denomination_company VARCHAR(100) DEFAULT NULL, siret_company VARCHAR(30) DEFAULT NULL, tva_company VARCHAR(50) DEFAULT NULL, profil_picture VARCHAR(255) DEFAULT NULL, cover_picture VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, register_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version_control (id INT AUTO_INCREMENT NOT NULL, name_version_control VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version_control_freelance (version_control_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_38C1A93298BA3C23 (version_control_id), INDEX IDX_38C1A932E8DF656B (freelance_id), PRIMARY KEY(version_control_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_category (id INT AUTO_INCREMENT NOT NULL, name_category VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_category_freelance (work_category_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_B8750C73D877D21 (work_category_id), INDEX IDX_B8750C73E8DF656B (freelance_id), PRIMARY KEY(work_category_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coding_language_freelance ADD CONSTRAINT FK_8D5424299552E5E2 FOREIGN KEY (coding_language_id) REFERENCES coding_language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coding_language_freelance ADD CONSTRAINT FK_8D542429E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE database_freelance ADD CONSTRAINT FK_A59503FCF0AA09DB FOREIGN KEY (database_id) REFERENCES `database` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE database_freelance ADD CONSTRAINT FK_A59503FCE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE framework_freelance ADD CONSTRAINT FK_AE0D189737AECF72 FOREIGN KEY (framework_id) REFERENCES framework (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE framework_freelance ADD CONSTRAINT FK_AE0D1897E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE methodology_freelance ADD CONSTRAINT FK_115C1D5ED22DC3B FOREIGN KEY (methodology_id) REFERENCES methodology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE methodology_freelance ADD CONSTRAINT FK_115C1D5EE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA16D3CEB FOREIGN KEY (send_mission_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C73176E35 FOREIGN KEY (receive_mission_id) REFERENCES freelance (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B02767B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id)');
        $this->addSql('ALTER TABLE platform_freelance ADD CONSTRAINT FK_BB97C73DFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE platform_freelance ADD CONSTRAINT FK_BB97C73DE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE social ADD CONSTRAINT FK_7161E187CCFA12B8 FOREIGN KEY (profile_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE spoken_language_freelance ADD CONSTRAINT FK_B761A24950D2B87B FOREIGN KEY (spoken_language_id) REFERENCES spoken_language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spoken_language_freelance ADD CONSTRAINT FK_B761A249E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_control_freelance ADD CONSTRAINT FK_38C1A93298BA3C23 FOREIGN KEY (version_control_id) REFERENCES version_control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_control_freelance ADD CONSTRAINT FK_38C1A932E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_category_freelance ADD CONSTRAINT FK_B8750C73D877D21 FOREIGN KEY (work_category_id) REFERENCES work_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_category_freelance ADD CONSTRAINT FK_B8750C73E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coding_language_freelance DROP FOREIGN KEY FK_8D5424299552E5E2');
        $this->addSql('ALTER TABLE coding_language_freelance DROP FOREIGN KEY FK_8D542429E8DF656B');
        $this->addSql('ALTER TABLE database_freelance DROP FOREIGN KEY FK_A59503FCF0AA09DB');
        $this->addSql('ALTER TABLE database_freelance DROP FOREIGN KEY FK_A59503FCE8DF656B');
        $this->addSql('ALTER TABLE framework_freelance DROP FOREIGN KEY FK_AE0D189737AECF72');
        $this->addSql('ALTER TABLE framework_freelance DROP FOREIGN KEY FK_AE0D1897E8DF656B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE92F8F78');
        $this->addSql('ALTER TABLE methodology_freelance DROP FOREIGN KEY FK_115C1D5ED22DC3B');
        $this->addSql('ALTER TABLE methodology_freelance DROP FOREIGN KEY FK_115C1D5EE8DF656B');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA16D3CEB');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C73176E35');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B02767B3B43D');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027E8DF656B');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FE8DF656B');
        $this->addSql('ALTER TABLE platform_freelance DROP FOREIGN KEY FK_BB97C73DFFE6496F');
        $this->addSql('ALTER TABLE platform_freelance DROP FOREIGN KEY FK_BB97C73DE8DF656B');
        $this->addSql('ALTER TABLE social DROP FOREIGN KEY FK_7161E187CCFA12B8');
        $this->addSql('ALTER TABLE spoken_language_freelance DROP FOREIGN KEY FK_B761A24950D2B87B');
        $this->addSql('ALTER TABLE spoken_language_freelance DROP FOREIGN KEY FK_B761A249E8DF656B');
        $this->addSql('ALTER TABLE version_control_freelance DROP FOREIGN KEY FK_38C1A93298BA3C23');
        $this->addSql('ALTER TABLE version_control_freelance DROP FOREIGN KEY FK_38C1A932E8DF656B');
        $this->addSql('ALTER TABLE work_category_freelance DROP FOREIGN KEY FK_B8750C73D877D21');
        $this->addSql('ALTER TABLE work_category_freelance DROP FOREIGN KEY FK_B8750C73E8DF656B');
        $this->addSql('DROP TABLE coding_language');
        $this->addSql('DROP TABLE coding_language_freelance');
        $this->addSql('DROP TABLE `database`');
        $this->addSql('DROP TABLE database_freelance');
        $this->addSql('DROP TABLE framework');
        $this->addSql('DROP TABLE framework_freelance');
        $this->addSql('DROP TABLE freelance');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE methodology');
        $this->addSql('DROP TABLE methodology_freelance');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE path');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE platform_freelance');
        $this->addSql('DROP TABLE professionnal');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE social');
        $this->addSql('DROP TABLE spoken_language');
        $this->addSql('DROP TABLE spoken_language_freelance');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE version_control');
        $this->addSql('DROP TABLE version_control_freelance');
        $this->addSql('DROP TABLE work_category');
        $this->addSql('DROP TABLE work_category_freelance');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
