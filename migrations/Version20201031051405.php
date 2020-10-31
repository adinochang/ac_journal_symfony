<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031051405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE ac_journal_user (
            id BIGINT IDENTITY NOT NULL, 
            name VARCHAR(50) NOT NULL, 
            email VARCHAR(50) NOT NULL, 
            email_verified_at DATETIME2(6), 
            password VARCHAR(100) NOT NULL, 
            created_at DATETIME2(6), 
            updated_at DATETIME2(6), 
            CONSTRAINT PK_ac_journal_user_id PRIMARY KEY NONCLUSTERED (id)
        )');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE ac_journal_user');
    }
}
