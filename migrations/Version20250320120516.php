<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320120516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, about_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_590C103D087DB59 (about_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103D087DB59 FOREIGN KEY (about_id) REFERENCES about (id)');
        $this->addSql('ALTER TABLE about ADD birthcountry VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE social_link CHANGE img_src img_src VARCHAR(255) DEFAULT NULL, CHANGE img_alt img_alt VARCHAR(255) DEFAULT NULL, CHANGE img_title img_title VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103D087DB59');
        $this->addSql('DROP TABLE experience');
        $this->addSql('ALTER TABLE about DROP birthcountry');
        $this->addSql('ALTER TABLE social_link CHANGE img_src img_src VARCHAR(255) NOT NULL, CHANGE img_alt img_alt VARCHAR(255) NOT NULL, CHANGE img_title img_title VARCHAR(255) NOT NULL');
    }
}
