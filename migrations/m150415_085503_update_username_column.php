<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_085503_update_username_column extends Migration
{
    public function up()
    {
        // Change the length of the 'username' column in the 'users' table
        $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING.'(255) NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING.'(25) NOT NULL');
    }
}
