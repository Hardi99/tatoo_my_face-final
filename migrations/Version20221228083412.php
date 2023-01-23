<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228083412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A1C4A5171');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A99DED506');
        $this->addSql('DROP INDEX uniq_65e8aa0a99ded506 ON rendez_vous');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A19EB6921 ON rendez_vous (client_id)');
        $this->addSql('DROP INDEX uniq_65e8aa0a1c4a5171 ON rendez_vous');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A4C91BDE4 ON rendez_vous (salon_id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A1C4A5171 FOREIGN KEY (salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A99DED506 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A19EB6921');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4C91BDE4');
        $this->addSql('DROP INDEX uniq_65e8aa0a19eb6921 ON rendez_vous');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A99DED506 ON rendez_vous (client_id)');
        $this->addSql('DROP INDEX uniq_65e8aa0a4c91bde4 ON rendez_vous');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A1C4A5171 ON rendez_vous (salon_id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4C91BDE4 FOREIGN KEY (salon_id) REFERENCES salon (id)');
    }
}
