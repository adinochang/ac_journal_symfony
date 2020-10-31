<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031054606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE ac_journal_answer (
            id BIGINT IDENTITY NOT NULL, 
            entry_id BIGINT NOT NULL, 
            question_id BIGINT NOT NULL, 
            answer_text NTEXT NOT NULL,
            created_at DATETIME2(6), 
            updated_at DATETIME2(6), 
            CONSTRAINT PK_ac_journal_answer_id PRIMARY KEY NONCLUSTERED (id),
            CONSTRAINT FK_ac_journal_answer_entry FOREIGN KEY (entry_id)
                REFERENCES ac_journal_entry (id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            CONSTRAINT FK_ac_journal_answer_question FOREIGN KEY (question_id)
                REFERENCES ac_journal_question (id)
                ON DELETE CASCADE
                ON UPDATE CASCADE              
        )');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE ac_journal_answer');
    }
}
