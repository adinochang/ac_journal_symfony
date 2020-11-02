<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102094845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE ac_journal_user (
            id BIGINT IDENTITY NOT NULL, 
            email NVARCHAR(180) NOT NULL,
            name NVARCHAR(50) NOT NULL,
            roles VARCHAR(MAX) NOT NULL, 
            password NVARCHAR(255) NOT NULL,
            created_at DATETIME2(6), 
            updated_at DATETIME2(6), 
            PRIMARY KEY (id)             
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BC2EFDF4E7927C74 ON ac_journal_user (email) WHERE email IS NOT NULL');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:json)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'ac_journal_user\', N\'COLUMN\', roles');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE ac_journal_user');
    }
}
