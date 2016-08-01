<?php

use yii\db\Schema;
use yii\db\Migration;

use infoweb\user\models\Profile;

class m160801_092441_add_registration_source_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'registration_source', Schema::TYPE_STRING.'(60) NOT NULL DEFAULT \'\'');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'registration_source');
    }
}