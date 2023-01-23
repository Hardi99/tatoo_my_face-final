<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227123012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE salon_tatoo_style (salon_id INT NOT NULL, tatoo_style_id INT NOT NULL, INDEX IDX_AF731BBF4C91BDE4 (salon_id), INDEX IDX_AF731BBF4795F070 (tatoo_style_id), PRIMARY KEY(salon_id, tatoo_style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salon_tatoo_style ADD CONSTRAINT FK_AF731BBF4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salon_tatoo_style ADD CONSTRAINT FK_AF731BBF4795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tatoo_style_salon DROP FOREIGN KEY FK_2B4541114C91BDE4');
        $this->addSql('ALTER TABLE tatoo_style_salon DROP FOREIGN KEY FK_2B4541114795F070');
        $this->addSql('DROP TABLE tatoo_style_salon');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tatoo_style_salon (tatoo_style_id INT NOT NULL, salon_id INT NOT NULL, INDEX IDX_2B4541114795F070 (tatoo_style_id), INDEX IDX_2B4541114C91BDE4 (salon_id), PRIMARY KEY(tatoo_style_id, salon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tatoo_style_salon ADD CONSTRAINT FK_2B4541114C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tatoo_style_salon ADD CONSTRAINT FK_2B4541114795F070 FOREIGN KEY (tatoo_style_id) REFERENCES tatoo_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salon_tatoo_style DROP FOREIGN KEY FK_AF731BBF4C91BDE4');
        $this->addSql('ALTER TABLE salon_tatoo_style DROP FOREIGN KEY FK_AF731BBF4795F070');
        $this->addSql('DROP TABLE salon_tatoo_style');
    }
}
