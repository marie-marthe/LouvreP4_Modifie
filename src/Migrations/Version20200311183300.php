<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311183300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billet (id INT AUTO_INCREMENT NOT NULL, price_id INT NOT NULL, reduction INT NOT NULL, date_billet DATETIME NOT NULL, INDEX IDX_1F034AF6D614C7E7 (price_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(150) NOT NULL, date_reservation DATETIME NOT NULL, email INT NOT NULL, code_reservation INT NOT NULL, image VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF6D614C7E7 FOREIGN KEY (price_id) REFERENCES reservation (id)');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE ticket');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF6D614C7E7');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, visit_date DATE NOT NULL, visit_duration NUMERIC(2, 1) NOT NULL, tickets_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, first_name_visitor VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, last_name_visitor VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, birthday_visitor DATE NOT NULL, reduction TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE reservation');
    }
}
