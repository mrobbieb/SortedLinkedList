<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030004659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sessions (sess_id CLOB NOT NULL, sess_data BLOB NOT NULL, sess_lifetime INTEGER NOT NULL, sess_time INTEGER NOT NULL, PRIMARY KEY(sess_id))');
        $this->addSql('CREATE INDEX sess_lifetime_idx ON sessions (sess_lifetime)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sorted_linked_list AS SELECT id, list, type, created_at, updated_at FROM sorted_linked_list');
        $this->addSql('DROP TABLE sorted_linked_list');
        $this->addSql('CREATE TABLE sorted_linked_list (id INTEGER NOT NULL, list CLOB NOT NULL --(DC2Type:json)
        , type VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('INSERT INTO sorted_linked_list (id, list, type, created_at, updated_at) SELECT id, list, type, created_at, updated_at FROM __temp__sorted_linked_list');
        $this->addSql('DROP TABLE __temp__sorted_linked_list');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sessions');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sorted_linked_list AS SELECT id, list, type, created_at, updated_at FROM sorted_linked_list');
        $this->addSql('DROP TABLE sorted_linked_list');
        $this->addSql('CREATE TABLE sorted_linked_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, list CLOB NOT NULL --(DC2Type:json)
        , type VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO sorted_linked_list (id, list, type, created_at, updated_at) SELECT id, list, type, created_at, updated_at FROM __temp__sorted_linked_list');
        $this->addSql('DROP TABLE __temp__sorted_linked_list');
    }
}
