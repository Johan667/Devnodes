<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203140905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance ADD picture VARCHAR(255) DEFAULT NULL, ADD biographie LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP profil_picture, DROP cover_picture, DROP description, DROP phone');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance DROP picture, DROP biographie');
        $this->addSql('ALTER TABLE `user` ADD profil_picture VARCHAR(255) DEFAULT NULL, ADD cover_picture VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(20) DEFAULT NULL');
    }
}
