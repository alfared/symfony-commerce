<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260715140933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog_attribute_options (id VARCHAR(36) NOT NULL, code VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, sort_order INT NOT NULL, enabled BOOLEAN NOT NULL, attribute_id VARCHAR(36) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_BEAC5E3B6E62EFA ON catalog_attribute_options (attribute_id)');
        $this->addSql('CREATE TABLE catalog_attributes (id VARCHAR(36) NOT NULL, code VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(32) NOT NULL, required BOOLEAN NOT NULL, filterable BOOLEAN NOT NULL, searchable BOOLEAN NOT NULL, variant_axis BOOLEAN NOT NULL, enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_84B16CAB77153098 ON catalog_attributes (code)');
        $this->addSql('ALTER TABLE catalog_attribute_options ADD CONSTRAINT FK_BEAC5E3B6E62EFA FOREIGN KEY (attribute_id) REFERENCES catalog_attributes (id) ON DELETE CASCADE NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_attribute_options DROP CONSTRAINT FK_BEAC5E3B6E62EFA');
        $this->addSql('DROP TABLE catalog_attribute_options');
        $this->addSql('DROP TABLE catalog_attributes');
    }
}
