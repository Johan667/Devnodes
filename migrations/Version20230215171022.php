<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215171022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance ADD is_vip TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE mission ADD status LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP state');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance DROP is_vip');
        $this->addSql('ALTER TABLE mission ADD state VARCHAR(255) DEFAULT NULL, DROP status');
    }
}
