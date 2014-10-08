<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Apihour\UserBundle\Entity\Role;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140809095644 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $guest             = Role::GUEST;
        $member            = Role::MEMBER;
        $admin             = Role::ADMIN;
        $client            = Role::CLIENT;
        $contractor        = Role::CONTRACTOR;
        $contractorOwner   = Role::CONTRACTOR_OWNER;
        $contractorTrader  = Role::CONTRACTOR_TRADER;
        $contractorManager = Role::CONTRACTOR_MANAGER;
        $contractorTele    = Role::CONTRACTOR_TELEMARKETING;
        $contractorWorker  = Role::CONTRACTOR_WORKER;

        $this->addSql("INSERT INTO roles (parent, name) VALUES (NULL, '{$guest}');");
        $this->addSql("SET @GuestParent:=(SELECT id FROM roles WHERE name = '{$guest}');");

        $this->addSql("INSERT INTO roles (parent, name) VALUES (@GuestParent, '{$member}');");
        $this->addSql("SET @MemberParent:=(SELECT id FROM roles WHERE name = '{$member}');");

        $this->addSql("INSERT INTO roles (parent, name) VALUES (@MemberParent, '{$admin}');");
        $this->addSql("INSERT INTO roles (parent, name) VALUES (@MemberParent, '{$client}');");
        $this->addSql("INSERT INTO roles (parent, name) VALUES (@MemberParent, '{$contractor}');");
        $this->addSql("SET @ContractorParent:=(SELECT id FROM roles WHERE name = '{$contractor}');");

        $this->addSql("INSERT INTO roles (parent, name) VALUES (@ContractorParent, '{$contractorOwner}');");
        $this->addSql("INSERT INTO roles (parent, name) VALUES (@ContractorParent, '{$contractorTrader}');");
        $this->addSql("INSERT INTO roles (parent, name) VALUES (@ContractorParent, '{$contractorManager}');");
        $this->addSql("INSERT INTO roles (parent, name) VALUES (@ContractorParent, '{$contractorTele}');");
        $this->addSql("INSERT INTO roles (parent, name) VALUES (@ContractorParent, '{$contractorWorker}')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
