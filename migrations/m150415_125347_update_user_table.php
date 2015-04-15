<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_125347_update_user_table extends Migration
{
    public function safeUp()
    {
        // Change the length of the 'username' column in the 'users' table
        $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING.'(255) NOT NULL');
        
        // Add a column for the user scope
        $this->addColumn('{{%user}}', 'scope', Schema::TYPE_STRING.'(10) DEFAULT \'backend\'');
        $this->createIndex('scope', '{{%user}}', 'scope');    
    }
    
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->dropIndex('scope', '{{%user}}');
        $this->dropColumn('{{%user}}', 'scope');
    }
}
