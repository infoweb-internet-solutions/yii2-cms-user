<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_095603_add_scope_field extends Migration
{
    public function safeUp()
    {
        // Add a column for the user scope
        $this->addColumn('{{%user}}', 'scope', Schema::TYPE_STRING.'(10) DEFAULT \'backend\'');
        $this->createIndex('scope', '{{%user}}', 'scope');    
    }

    public function safeDown()
    {
        $this->dropIndex('scope', '{{%user}}');
        $this->dropColumn('{{%user}}', 'scope');    
    }
}
