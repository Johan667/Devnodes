<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218103531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C727ACA70 FOREIGN KEY (parent_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_9474526C727ACA70 ON comment (parent_id)');
        $this->addSql('ALTER TABLE mission DROP state');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA16D3CEB FOREIGN KEY (send_mission_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C73176E35 FOREIGN KEY (receive_mission_id) REFERENCES freelance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C727ACA70');
        $this->addSql('DROP INDEX IDX_9474526C727ACA70 ON comment');
        $this->addSql('ALTER TABLE comment DROP parent_id');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA16D3CEB');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C73176E35');
        $this->addSql('ALTER TABLE mission ADD state VARCHAR(255) DEFAULT NULL');
    }
}
