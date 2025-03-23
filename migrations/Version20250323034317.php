<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323034317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE social_link (id INT AUTO_INCREMENT NOT NULL, about_id INT DEFAULT NULL, platform VARCHAR(255) NOT NULL, href VARCHAR(255) NOT NULL, img_src VARCHAR(255) DEFAULT NULL, img_alt VARCHAR(255) DEFAULT NULL, img_title VARCHAR(255) DEFAULT NULL, INDEX IDX_79BD4A95D087DB59 (about_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE social_link ADD CONSTRAINT FK_79BD4A95D087DB59 FOREIGN KEY (about_id) REFERENCES about (id)');
        $this->addSql('ALTER TABLE about DROP social_links_platform, DROP social_links_href, DROP social_links_img_src, DROP social_links_img_alt, DROP social_links_img_title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE social_link DROP FOREIGN KEY FK_79BD4A95D087DB59');
        $this->addSql('DROP TABLE social_link');
        $this->addSql('ALTER TABLE about ADD social_links_platform VARCHAR(255) NOT NULL, ADD social_links_href VARCHAR(255) NOT NULL, ADD social_links_img_src VARCHAR(255) DEFAULT NULL, ADD social_links_img_alt VARCHAR(255) DEFAULT NULL, ADD social_links_img_title VARCHAR(255) DEFAULT NULL');
    }
}
