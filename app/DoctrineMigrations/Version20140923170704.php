<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

use Tutto\CommonBundle\Tools\Status;
use Apihour\UserBundle\Repository\Account\AccountHasPrivilegeRepository;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140923170704 extends AbstractMigration {
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        $this->addSql("INSERT INTO accounts_privileges (name, defaultValue, status) VALUES
            ('".AccountHasPrivilegeRepository::MAX_USERS_PER_ACCOUNT."', 7, ".Status::ENABLED."),
            ('".AccountHasPrivilegeRepository::CAN_CREATE_PRODUCTS_PACKAGES."', 1, ".Status::ENABLED.")
            ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
