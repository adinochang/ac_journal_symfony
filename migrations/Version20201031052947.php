<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031052947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE ac_journal_question (
            id BIGINT IDENTITY NOT NULL, 
            label VARCHAR(200) NOT NULL,
            sort_order int NOT NULL DEFAULT 1,
            required BIT NOT NULL DEFAULT 1, 
            enabled BIT NOT NULL DEFAULT 1, 
            created_at DATETIME2(6), 
            updated_at DATETIME2(6), 
            CONSTRAINT PK_ac_journal_question_id PRIMARY KEY NONCLUSTERED (id)
        )');

        $this->addSql('CREATE TABLE ac_journal_entry (
            id BIGINT IDENTITY NOT NULL, 
            author BIGINT, 
            created_at DATETIME2(6), 
            updated_at DATETIME2(6), 
            CONSTRAINT PK_ac_journal_entry_id PRIMARY KEY NONCLUSTERED (id)
        )');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE ac_journal_question');
        $this->addSql('DROP TABLE ac_journal_entry');
    }
}
