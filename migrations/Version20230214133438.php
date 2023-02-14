<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214133438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance ADD is_vip TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD mission_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FBE6CAE90 ON message (mission_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance DROP is_vip');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FBE6CAE90');
        $this->addSql('DROP INDEX IDX_B6BD307FBE6CAE90 ON message');
        $this->addSql('ALTER TABLE message DROP mission_id');
    }
}
