<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251214231848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fournisseur_produit (fournisseur_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_FB65A38A670C757F (fournisseur_id), INDEX IDX_FB65A38AF347EFB (produit_id), PRIMARY KEY(fournisseur_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fournisseur_produit ADD CONSTRAINT FK_FB65A38A670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_produit ADD CONSTRAINT FK_FB65A38AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fournisseur_produit DROP FOREIGN KEY FK_FB65A38A670C757F');
        $this->addSql('ALTER TABLE fournisseur_produit DROP FOREIGN KEY FK_FB65A38AF347EFB');
        $this->addSql('DROP TABLE fournisseur_produit');
    }
}
