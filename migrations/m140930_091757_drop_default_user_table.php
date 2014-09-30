<?php

use yii\db\Schema;
use yii\db\Migration;

class m140930_091757_drop_default_user_table extends Migration
{
    public function up()
    {
        // Drop the default user and profile table
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%profile}}');
    }

    public function down()
    {
        echo "m140930_091757_drop_default_user_table cannot be reverted.\n";

        return false;
    }
}
