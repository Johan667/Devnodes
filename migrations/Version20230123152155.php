<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123152155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027E8DF656B');
        $this->addSql('DROP INDEX IDX_AB02B027E8DF656B ON opinion');
        $this->addSql('ALTER TABLE opinion DROP freelance_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinion ADD freelance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AB02B027E8DF656B ON opinion (freelance_id)');
    }
}
