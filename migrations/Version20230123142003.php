<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123142003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE path ADD discr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE professionnal CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE professionnal ADD CONSTRAINT FK_1E44040BBF396750 FOREIGN KEY (id) REFERENCES path (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABBBF396750 FOREIGN KEY (id) REFERENCES path (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE path DROP discr');
        $this->addSql('ALTER TABLE professionnal DROP FOREIGN KEY FK_1E44040BBF396750');
        $this->addSql('ALTER TABLE professionnal CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABBBF396750');
        $this->addSql('ALTER TABLE school CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
