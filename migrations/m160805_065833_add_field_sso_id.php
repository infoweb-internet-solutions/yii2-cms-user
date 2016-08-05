<?php

use yii\db\Schema;
use yii\db\Migration;

class m160805_065833_add_field_sso_id extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'sso_id', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'sso_id');
    }
}
