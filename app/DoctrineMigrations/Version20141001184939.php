<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141001184939 extends AbstractMigration {
    public function up(Schema $schema) {
        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlements_prefix', 'for_invoices', 's:3:\"FAV\";', 'text', 'a:1:{s:8:\"required\";i:1;}');
        ");

        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlements_prefix', 'for_bills', 's:1:\"R\";', 'text', 'a:1:{s:8:\"required\";i:1;}');
        ");

        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlements_prefix', 'for_proforma', 's:3:\"PRO\";', 'text', 'a:1:{s:8:\"required\";i:1;}');
        ");

        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlements_prefix', 'for_corrective_invoices', 's:3:\"KOR\";', 'text', 'a:1:{s:8:\"required\";i:1;}');
        ");

        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlements_prefix', 'for_prepayment_invoices', 's:3:\"FZA\";', 'text', 'a:1:{s:8:\"required\";i:1;}');
        ");

        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlements_prefix', 'for_final_invoices', 's:3:\"FKO\";', 'text', 'a:1:{s:8:\"required\";i:1;}');
        ");

        $this->addSql("
            INSERT INTO accounts_options
            (`group`, name, `default`, type, constraints)
            VALUES ('settlement', 'invoicing_mode', 's:7:\"monthly\";', 'choice', 'a:2:{s:8:\"required\";i:1;s:7:\"choices\";a:3:{i:0;s:7:\"monthly\";i:1;s:8:\"annually\";i:2;s:9:\"quarterly\";}}');
        ");
    }

    public function down(Schema $schema) { }
}
