<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611145522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE cagnotte (id INT AUTO_INCREMENT NOT NULL, commande_famille_id INT NOT NULL, montant_objectif DOUBLE PRECISION NOT NULL, montant_actuel DOUBLE PRECISION NOT NULL, statut VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_6342C752F655762 (commande_famille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(70) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commande_famille (id INT AUTO_INCREMENT NOT NULL, famille_id INT NOT NULL, paiement_id INT NOT NULL, statut VARCHAR(30) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_D2C880B397A77B84 (famille_id), INDEX IDX_D2C880B32A4C4478 (paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commande_vendeur (id INT AUTO_INCREMENT NOT NULL, commande_famille_id INT NOT NULL, transaction_id INT NOT NULL, statut VARCHAR(30) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, total_commande_v DOUBLE PRECISION DEFAULT NULL, INDEX IDX_8C4FEB36F655762 (commande_famille_id), INDEX IDX_8C4FEB362FC0CB0F (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE donateur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, est_anonyme TINYINT(1) DEFAULT NULL, montant_total_don DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_9CD3DE50A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, famille_id INT NOT NULL, note INT NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_1323A57597A77B84 (famille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE famille (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, parrain_id INT DEFAULT NULL, nombre_membres INT DEFAULT NULL, revenu_mensuel DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_2473F213A76ED395 (user_id), INDEX IDX_2473F213DE2A7A37 (parrain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ligne_produit (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_vendeur_id INT NOT NULL, quantite DOUBLE PRECISION NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, total_ligne DOUBLE PRECISION NOT NULL, est_validee TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_B63CD21EF347EFB (produit_id), INDEX IDX_B63CD21E1D4E2AB8 (commande_vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, vue TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, donateur_id INT NOT NULL, plateforme_id INT DEFAULT NULL, montant_total DOUBLE PRECISION NOT NULL, moyen_paiement VARCHAR(150) NOT NULL, statut VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_B1DC7A1EA9C80E3 (donateur_id), INDEX IDX_B1DC7A1E391E226B (plateforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE paiement_cagnotte (id INT AUTO_INCREMENT NOT NULL, donateur_id INT NOT NULL, cagnotte_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, statut VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_A9E53F68A9C80E3 (donateur_id), INDEX IDX_A9E53F6815105EB8 (cagnotte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plateforme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE probleme (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(300) NOT NULL, statut VARCHAR(30) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_7AB2D714A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, nom_produit VARCHAR(70) NOT NULL, description VARCHAR(200) DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, quantite_dispo DOUBLE PRECISION NOT NULL, est_disponible TINYINT(1) NOT NULL, image_url VARCHAR(200) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_29A5EC27858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transaction_vendeur (id INT AUTO_INCREMENT NOT NULL, plateforme_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, moyen_transfert VARCHAR(50) NOT NULL, statut VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, INDEX IDX_C5EA574391E226B (plateforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, type_utilisateur VARCHAR(15) NOT NULL, civilite VARCHAR(10) DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, adresse VARCHAR(150) DEFAULT NULL, compl_adresse VARCHAR(50) DEFAULT NULL, code_postal VARCHAR(10) DEFAULT NULL, ville VARCHAR(70) DEFAULT NULL, pays VARCHAR(70) DEFAULT NULL, statut VARCHAR(30) DEFAULT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vendeur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom_societe VARCHAR(50) DEFAULT NULL, siren INT DEFAULT NULL, UNIQUE INDEX UNIQ_7AF49996A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cagnotte ADD CONSTRAINT FK_6342C752F655762 FOREIGN KEY (commande_famille_id) REFERENCES commande_famille (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_famille ADD CONSTRAINT FK_D2C880B397A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_famille ADD CONSTRAINT FK_D2C880B32A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_vendeur ADD CONSTRAINT FK_8C4FEB36F655762 FOREIGN KEY (commande_famille_id) REFERENCES commande_famille (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_vendeur ADD CONSTRAINT FK_8C4FEB362FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction_vendeur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donateur ADD CONSTRAINT FK_9CD3DE50A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57597A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE famille ADD CONSTRAINT FK_2473F213A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE famille ADD CONSTRAINT FK_2473F213DE2A7A37 FOREIGN KEY (parrain_id) REFERENCES donateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_produit ADD CONSTRAINT FK_B63CD21EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_produit ADD CONSTRAINT FK_B63CD21E1D4E2AB8 FOREIGN KEY (commande_vendeur_id) REFERENCES commande_vendeur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EA9C80E3 FOREIGN KEY (donateur_id) REFERENCES donateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement_cagnotte ADD CONSTRAINT FK_A9E53F68A9C80E3 FOREIGN KEY (donateur_id) REFERENCES donateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement_cagnotte ADD CONSTRAINT FK_A9E53F6815105EB8 FOREIGN KEY (cagnotte_id) REFERENCES cagnotte (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE probleme ADD CONSTRAINT FK_7AB2D714A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27858C065E FOREIGN KEY (vendeur_id) REFERENCES vendeur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_vendeur ADD CONSTRAINT FK_C5EA574391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vendeur ADD CONSTRAINT FK_7AF49996A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cagnotte DROP FOREIGN KEY FK_6342C752F655762
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_famille DROP FOREIGN KEY FK_D2C880B397A77B84
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_famille DROP FOREIGN KEY FK_D2C880B32A4C4478
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_vendeur DROP FOREIGN KEY FK_8C4FEB36F655762
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande_vendeur DROP FOREIGN KEY FK_8C4FEB362FC0CB0F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donateur DROP FOREIGN KEY FK_9CD3DE50A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57597A77B84
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE famille DROP FOREIGN KEY FK_2473F213A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE famille DROP FOREIGN KEY FK_2473F213DE2A7A37
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_produit DROP FOREIGN KEY FK_B63CD21EF347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_produit DROP FOREIGN KEY FK_B63CD21E1D4E2AB8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EA9C80E3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E391E226B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement_cagnotte DROP FOREIGN KEY FK_A9E53F68A9C80E3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement_cagnotte DROP FOREIGN KEY FK_A9E53F6815105EB8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE probleme DROP FOREIGN KEY FK_7AB2D714A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27858C065E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_vendeur DROP FOREIGN KEY FK_C5EA574391E226B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vendeur DROP FOREIGN KEY FK_7AF49996A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cagnotte
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande_famille
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande_vendeur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE donateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE evaluation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE famille
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ligne_produit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notification
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE paiement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE paiement_cagnotte
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plateforme
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE probleme
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transaction_vendeur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vendeur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
