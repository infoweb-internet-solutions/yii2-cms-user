<?php

use yii\db\Schema;
use yii\db\Migration;

class m160801_071042_add_count_login_fields extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'last_login', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');
        $this->addColumn('{{%profile}}', 'count_login_site', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');
        $this->addColumn('{{%profile}}', 'count_login_sso', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'last_login');
        $this->dropColumn('{{%profile}}', 'count_login_site');
        $this->dropColumn('{{%profile}}', 'count_login_sso');
    }
}