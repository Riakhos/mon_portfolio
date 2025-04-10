<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319103553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about (id INT AUTO_INCREMENT NOT NULL, birthdate DATE NOT NULL, email VARCHAR(180) NOT NULL, phone VARCHAR(255) NOT NULL, zoom VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, about_me LONGTEXT NOT NULL, title_experience VARCHAR(255) NOT NULL, description_experience LONGTEXT NOT NULL, skills LONGTEXT NOT NULL, languages LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE about1 (id INT AUTO_INCREMENT NOT NULL, birthdate VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, zoom VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, about_me LONGTEXT NOT NULL, experience LONGTEXT NOT NULL, skills LONGTEXT NOT NULL, languages LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE about1');
    }
}
