<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206112932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_freelance (user_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_484B4B91A76ED395 (user_id), INDEX IDX_484B4B91E8DF656B (freelance_id), PRIMARY KEY(user_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_freelance ADD CONSTRAINT FK_484B4B91A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_freelance ADD CONSTRAINT FK_484B4B91E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_freelance DROP FOREIGN KEY FK_484B4B91A76ED395');
        $this->addSql('ALTER TABLE user_freelance DROP FOREIGN KEY FK_484B4B91E8DF656B');
        $this->addSql('DROP TABLE user_freelance');
    }
}
