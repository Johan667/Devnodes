<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123153946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, comments_id INT DEFAULT NULL, received_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C63379586 (comments_id), INDEX IDX_9474526CB821E5F5 (received_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C63379586 FOREIGN KEY (comments_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB821E5F5 FOREIGN KEY (received_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B02767B3B43D');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027E8DF656B');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('ALTER TABLE path ADD school_id INT DEFAULT NULL, ADD discr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_B548B0FC32A47EE ON path (school_id)');
        $this->addSql('ALTER TABLE professionnal CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE professionnal ADD CONSTRAINT FK_1E44040BBF396750 FOREIGN KEY (id) REFERENCES path (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABBBF396750 FOREIGN KEY (id) REFERENCES path (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE opinion (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, freelance_id INT DEFAULT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_opinion DATE DEFAULT NULL, star INT DEFAULT NULL, INDEX IDX_AB02B02767B3B43D (users_id), INDEX IDX_AB02B027E8DF656B (freelance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B02767B3B43D FOREIGN KEY (users_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C63379586');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB821E5F5');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC32A47EE');
        $this->addSql('DROP INDEX IDX_B548B0FC32A47EE ON path');
        $this->addSql('ALTER TABLE path DROP school_id, DROP discr');
        $this->addSql('ALTER TABLE professionnal DROP FOREIGN KEY FK_1E44040BBF396750');
        $this->addSql('ALTER TABLE professionnal CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABBBF396750');
        $this->addSql('ALTER TABLE school CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
