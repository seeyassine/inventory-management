<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251216235220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, client_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date_paiment DATETIME NOT NULL, remarque VARCHAR(255) DEFAULT NULL, mode VARCHAR(255) NOT NULL, INDEX IDX_6D28840D7F2DEE08 (facture_id), INDEX IDX_6D28840D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D7F2DEE08');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D19EB6921');
        $this->addSql('DROP TABLE payment');
    }
}
