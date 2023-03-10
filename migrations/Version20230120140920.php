<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120140920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554795F070');
        $this->addSql('DROP INDEX IDX_42C849554795F070 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP tatoo_style_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD tatoo_style_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id)');
        $this->addSql('CREATE INDEX IDX_42C849554795F070 ON reservation (tatoo_style_id)');
    }
}
