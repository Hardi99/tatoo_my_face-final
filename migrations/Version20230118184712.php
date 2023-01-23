<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118184712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD date DATETIME NOT NULL, ADD start_time TIME NOT NULL, ADD end_time TIME NOT NULL, DROP phone, DROP start, DROP end, DROP report');
        $this->addSql('ALTER TABLE salon CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD phone VARCHAR(255) NOT NULL, ADD end DATETIME NOT NULL, ADD report DATETIME DEFAULT NULL, DROP start_time, DROP end_time, CHANGE date start DATETIME NOT NULL');
        $this->addSql('ALTER TABLE salon CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
