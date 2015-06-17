<?php

use yii\db\Schema;
use yii\db\Migration;

class m150617_134553_add_language_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'language', Schema::TYPE_STRING.'(2) NOT NULL DEFAULT \'nl\'');
    }

    public function down()
    {
        $this->dropColumn('{{%profile}}', 'language');
    }
}
