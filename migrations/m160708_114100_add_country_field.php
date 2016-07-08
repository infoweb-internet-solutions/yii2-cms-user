<?php

use yii\db\Schema;
use yii\db\Migration;
use infoweb\user\models\Profile;

class m160708_114100_add_country_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'country', Schema::TYPE_STRING.'(255) NOT NULL DEFAULT \''.Profile::COUNTRY_BE.'\'');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'country');
    }
}
