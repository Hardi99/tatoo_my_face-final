<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118101220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, salons_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, report DATETIME DEFAULT NULL, color VARCHAR(255) NOT NULL, text_color VARCHAR(255) NOT NULL, INDEX IDX_42C84955405A0AF9 (salons_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_tatoo_style (reservation_id INT NOT NULL, tatoo_style_id INT NOT NULL, INDEX IDX_608CB18B83297E7 (reservation_id), INDEX IDX_608CB184795F070 (tatoo_style_id), PRIMARY KEY(reservation_id, tatoo_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salon_tatoo_style (salon_id INT NOT NULL, tatoo_style_id INT NOT NULL, INDEX IDX_AF731BBF4C91BDE4 (salon_id), INDEX IDX_AF731BBF4795F070 (tatoo_style_id), PRIMARY KEY(salon_id, tatoo_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955405A0AF9 FOREIGN KEY (salons_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE reservation_tatoo_style ADD CONSTRAINT FK_608CB18B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_tatoo_style ADD CONSTRAINT FK_608CB184795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salon_tatoo_style ADD CONSTRAINT FK_AF731BBF4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salon_tatoo_style ADD CONSTRAINT FK_AF731BBF4795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salon ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955405A0AF9');
        $this->addSql('ALTER TABLE reservation_tatoo_style DROP FOREIGN KEY FK_608CB18B83297E7');
        $this->addSql('ALTER TABLE reservation_tatoo_style DROP FOREIGN KEY FK_608CB184795F070');
        $this->addSql('ALTER TABLE salon_tatoo_style DROP FOREIGN KEY FK_AF731BBF4C91BDE4');
        $this->addSql('ALTER TABLE salon_tatoo_style DROP FOREIGN KEY FK_AF731BBF4795F070');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_tatoo_style');
        $this->addSql('DROP TABLE salon_tatoo_style');
        $this->addSql('ALTER TABLE salon DROP updated_at');
    }
}
