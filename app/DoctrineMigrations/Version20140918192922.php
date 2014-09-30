<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use DateTime;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140918192922 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $date = new DateTime();
        $time = $date->format('Y-m-d H:i:s');

        $this->addSql("INSERT INTO currencies (currency, createdAt, status, isDeleted) VALUES ('PLN', '{$time}', 1, 0);");
        $this->addSql("INSERT INTO currencies (currency, createdAt, status, isDeleted) VALUES ('EUR', '{$time}', 1, 0);");
        $this->addSql("INSERT INTO currencies (currency, createdAt, status, isDeleted) VALUES ('USD', '{$time}', 1, 0);");
        $this->addSql("INSERT INTO currencies (currency, createdAt, status, isDeleted) VALUES ('GBP', '{$time}', 1, 0);");
        $this->addSql("INSERT INTO currencies (currency, createdAt, status, isDeleted) VALUES ('CAD', '{$time}', 1, 0);");
        $this->addSql("INSERT INTO currencies (currency, createdAt, status, isDeleted) VALUES ('AUD', '{$time}', 1, 0);");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
