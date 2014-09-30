<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

use Apihour\UserBundle\Entity\Role;
use Apihour\UserBundle\Entity\Account\AccountType;
use DateTime;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140907152131 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $contractorOwner = Role::CONTRACTOR_OWNER;

        $date            = new DateTime();
        $goldAccountType = AccountType::TYPE_GOLD;
        $datetime        = $date->format('Y-m-d H:i:s');

        $this->addSql("SET @RoleId:=(SELECT id FROM roles WHERE name = '{$contractorOwner}');");
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
                'admin@apihour.net',
                'admin@apihour.net',
                'admin@apihour.net',
                'admin@apihour.net',
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

        $this->addSql("
            INSERT INTO files (created_by, modified_by, basePath, filename, ext, createdAt, modifiedAt, status, isDeleted)
            VALUES (
                @UserId,
                @UserId,
                'http://apihour.dev/public/users/accounts/1',
                'avatar-1',
                'jpg',
                '".$date->format('Y-m-d H:i:s')."',
                '".$date->format('Y-m-d H:i:s')."',
                1,
                0
            );
        ");
        $this->addSql("SET @Avatar:=(SELECT id FROM files ORDER BY id DESC LIMIT 1);");
        $this->addSql("UPDATE person SET avatar = @Avatar WHERE id = @PersonId;");
    }

    public function down(Schema $schema)
    {
    }
}
