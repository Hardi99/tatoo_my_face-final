<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119205956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_tatoo_style DROP FOREIGN KEY FK_608CB18B83297E7');
        $this->addSql('ALTER TABLE reservation_tatoo_style DROP FOREIGN KEY FK_608CB184795F070');
        $this->addSql('DROP TABLE reservation_tatoo_style');
        $this->addSql('ALTER TABLE reservation ADD tatoo_style_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id)');
        $this->addSql('CREATE INDEX IDX_42C849554795F070 ON reservation (tatoo_style_id)');
        $this->addSql('ALTER TABLE salon DROP filename');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_tatoo_style (reservation_id INT NOT NULL, tatoo_style_id INT NOT NULL, INDEX IDX_608CB18B83297E7 (reservation_id), INDEX IDX_608CB184795F070 (tatoo_style_id), PRIMARY KEY(reservation_id, tatoo_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation_tatoo_style ADD CONSTRAINT FK_608CB18B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_tatoo_style ADD CONSTRAINT FK_608CB184795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554795F070');
        $this->addSql('DROP INDEX IDX_42C849554795F070 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP tatoo_style_id');
        $this->addSql('ALTER TABLE salon ADD filename VARCHAR(255) DEFAULT NULL');
    }
}
