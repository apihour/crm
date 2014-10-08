<?php

namespace Application\Migrations;

use Apihour\UserBundle\Entity\Account\AccountType;
use Apihour\UserBundle\Entity\Role;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use DateTime;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141006183550 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $goldAccountType = AccountType::TYPE_GOLD;
        $date            = new DateTime();
        $datetime        = $date->format('Y-m-d H:i:s');
        $adminRole = Role::ADMIN;

        $this->addSql("SET @RoleId:=(SELECT id FROM roles WHERE name = '{$adminRole}');");
        $this->addSql("INSERT INTO person (firstname, lastname, phones, emails) VALUES ('admin', 'admin', 'a:0:{}', 'a:0:{}');");
        $this->addSql("SET @PersonId:=(SELECT id FROM person ORDER BY id DESC LIMIT 1);");
        $this->addSql("INSERT INTO accounts (type, status, createdAt, modifiedAt) VALUES({$goldAccountType}, 1, '{$datetime}', '{$datetime}')");
        $this->addSql("SET @AccountId:=(SELECT id FROM accounts ORDER BY id DESC LIMIT 1);");
        $this->addSql("
            INSERT INTO users (
                username,
                username_canonical,
                email,
                email_canonical,
                enabled,
                salt,
                password,
                expires_at,
                roles
            ) VALUES (
                'fluke.kuczwa@gmail.com',
                'fluke.kuczwa@gmail.com',
                'fluke.kuczwa@gmail.com',
                'fluke.kuczwa@gmail.com',
                1,
                'oq26b75k9us4ksgswk0cs4w8w0w0co4',
                '/c4mEkodtjy966H+cRfSgXJ7WM9+D5jf9gawQK0372MN/q4exrqUX/+2UemqWjHfGJGBY0IGgVkurCKJQW58QA==',
                '2020-01-01 00:00:00',
                'a:0:{}'
            );
        ");


        $this->addSql("SET @UserId:=(SELECT id FROM users ORDER BY id DESC LIMIT 1);");
        $this->addSql("
            INSERT INTO users_has_accounts (user_id, account_id, role_id, person_id)
            VALUES (@UserId, @AccountId, @RoleId, @PersonId)
        ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
