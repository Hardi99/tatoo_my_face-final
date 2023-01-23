<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230103172503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date_salon (date_id INT NOT NULL, salon_id INT NOT NULL, INDEX IDX_48981C9BB897366B (date_id), INDEX IDX_48981C9B4C91BDE4 (salon_id), PRIMARY KEY(date_id, salon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE date_salon ADD CONSTRAINT FK_48981C9BB897366B FOREIGN KEY (date_id) REFERENCES date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE date_salon ADD CONSTRAINT FK_48981C9B4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE date_salon DROP FOREIGN KEY FK_48981C9BB897366B');
        $this->addSql('ALTER TABLE date_salon DROP FOREIGN KEY FK_48981C9B4C91BDE4');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE date_salon');
    }
}
