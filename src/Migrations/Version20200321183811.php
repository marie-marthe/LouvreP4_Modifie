<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200321183811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP id_command');
        $this->addSql('ALTER TABLE client ADD idcommand_id INT NOT NULL, DROP idcommand');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455FE4875A0 FOREIGN KEY (idcommand_id) REFERENCES command (id)');
        $this->addSql('CREATE INDEX IDX_C7440455FE4875A0 ON client (idcommand_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455FE4875A0');
        $this->addSql('DROP INDEX IDX_C7440455FE4875A0 ON client');
        $this->addSql('ALTER TABLE client ADD idcommand VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP idcommand_id');
        $this->addSql('ALTER TABLE command ADD id_command VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
