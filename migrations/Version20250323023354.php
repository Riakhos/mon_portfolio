<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323023354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about ADD social_links JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP social_links_platform, DROP social_links_href, DROP social_links_img_src, DROP social_links_img_alt, DROP social_links_img_title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about ADD social_links_platform VARCHAR(255) NOT NULL, ADD social_links_href VARCHAR(255) NOT NULL, ADD social_links_img_src VARCHAR(255) DEFAULT NULL, ADD social_links_img_alt VARCHAR(255) DEFAULT NULL, ADD social_links_img_title VARCHAR(255) DEFAULT NULL, DROP social_links');
    }
}
