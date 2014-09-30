<?php

namespace Application\Migrations;

use Apihour\UserBundle\Entity\Account\AccountType;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140907151252 extends AbstractMigration {
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        $free     = AccountType::TYPE_FREE;
        $premium  = AccountType::TYPE_PREMIUM;
        $silver   = AccountType::TYPE_SILVER;
        $gold     = AccountType::TYPE_GOLD;
        $platinum = AccountType::TYPE_PLATINUM;

        $this->addSql("INSERT INTO accounts_types (id, name) VALUES ('{$free}', 'free')");
        $this->addSql("INSERT INTO accounts_types (id, name) VALUES ('{$premium}', 'premium')");
        $this->addSql("INSERT INTO accounts_types (id, name) VALUES ('{$silver}', 'silver') ");
        $this->addSql("INSERT INTO accounts_types (id, name) VALUES ('{$gold}', 'gold') ");
        $this->addSql("INSERT INTO accounts_types (id, name) VALUES ('{$platinum}', 'platinum') ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) { }
}
