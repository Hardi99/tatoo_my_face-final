<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227111044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tatoo_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tatoo_style_salon (tatoo_style_id INT NOT NULL, salon_id INT NOT NULL, INDEX IDX_2B4541114795F070 (tatoo_style_id), INDEX IDX_2B4541114C91BDE4 (salon_id), PRIMARY KEY(tatoo_style_id, salon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tatoo_style_salon ADD CONSTRAINT FK_2B4541114795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tatoo_style_salon ADD CONSTRAINT FK_2B4541114C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE appointment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hour TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tatoo_style_salon DROP FOREIGN KEY FK_2B4541114795F070');
        $this->addSql('ALTER TABLE tatoo_style_salon DROP FOREIGN KEY FK_2B4541114C91BDE4');
        $this->addSql('DROP TABLE tatoo_style');
        $this->addSql('DROP TABLE tatoo_style_salon');
    }
}
