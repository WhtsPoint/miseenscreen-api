<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250327194934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE call_form (id VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, fullName LONGTEXT NOT NULL, companyName LONGTEXT NOT NULL, employeeNumber LONGTEXT NOT NULL, phone LONGTEXT NOT NULL, email LONGTEXT NOT NULL, files JSON NOT NULL, posted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', services VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, admin_comment LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, posted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A3C664D3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE call_form');
        $this->addSql('DROP TABLE subscription');
    }
}
