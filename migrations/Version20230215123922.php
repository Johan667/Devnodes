<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215123922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C73176E35');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA16D3CEB');
        $this->addSql('ALTER TABLE mission ADD status LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP state');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C73176E35 FOREIGN KEY (receive_mission_id) REFERENCES freelance (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA16D3CEB FOREIGN KEY (send_mission_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC32A47EE');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FE8DF656B');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA16D3CEB');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C73176E35');
        $this->addSql('ALTER TABLE mission ADD state VARCHAR(255) DEFAULT NULL, DROP status');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA16D3CEB FOREIGN KEY (send_mission_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C73176E35 FOREIGN KEY (receive_mission_id) REFERENCES freelance (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FE8DF656B');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC32A47EE');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON UPDATE NO ACTION ON DELETE SET NULL');
    }
}
