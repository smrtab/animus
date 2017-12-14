<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171210124531 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
	    $this->addSql('CREATE SEQUENCE apartments_id_seq;');
        $this->addSql('CREATE TABLE apartments (
          id int NOT NULL DEFAULT nextval(\'apartments_id_seq\'),
          move_in_date date default NULL,
          street varchar(255) NOT NULL,
          post_code int NOT NULL,
          town varchar(100) NOT NULL,
          country varchar(100) NOT NULL,
          email varchar(255) NOT NULL,
          CONSTRAINT apartments_pkey PRIMARY KEY (id));');
    }
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE apartments');
	    $this->addSql('DROP SEQUENCE apartments_id_seq;');
    }
}
