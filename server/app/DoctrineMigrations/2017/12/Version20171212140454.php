<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171212140454 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
	    $this->addSql('CREATE TABLE apartment_tokens (
          id int NOT NULL,
          apartment_id int NOT NULL,
          token varchar(36) NOT NULL,
          CONSTRAINT apartment_tokens_pkey PRIMARY KEY (id));');

	    $this->addSql('CREATE SEQUENCE apartment_tokens_id_seq;');
	    $this->addSql('ALTER TABLE apartment_tokens ALTER COLUMN id SET DEFAULT nextval(\'apartment_tokens_id_seq\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
	    $this->addSql('DROP TABLE apartment_tokens');
	    $this->addSql('DROP SEQUENCE apartment_tokens_id_seq;');
    }
}
