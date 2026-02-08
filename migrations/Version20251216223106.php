<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251216223106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE linge_devis (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, devis_id INT DEFAULT NULL, quantite INT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, tva_taux DOUBLE PRECISION NOT NULL, remise_pourcentage DOUBLE PRECISION NOT NULL, INDEX IDX_3B67826BF347EFB (produit_id), INDEX IDX_3B67826B41DEFADA (devis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE linge_devis ADD CONSTRAINT FK_3B67826BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE linge_devis ADD CONSTRAINT FK_3B67826B41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linge_devis DROP FOREIGN KEY FK_3B67826BF347EFB');
        $this->addSql('ALTER TABLE linge_devis DROP FOREIGN KEY FK_3B67826B41DEFADA');
        $this->addSql('DROP TABLE linge_devis');
    }
}
