<?php

use yii\db\Schema;
use yii\db\Migration;

class m160805_071319_make_email_field_nullable extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'email', Schema::TYPE_STRING.'(255) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'email', Schema::TYPE_STRING.'(255) NOT NULL');
    }
}
