<?php

use yii\db\Schema;
use yii\db\Migration;

class m160708_125913_add_doctorcode_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'doctorcode', Schema::TYPE_STRING.'(255) NOT NULL DEFAULT \'\'');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'doctorcode');
    }
}
