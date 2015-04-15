<?php

use yii\db\Schema;
use yii\db\Migration;

class m150415_081317_extend_profile extends Migration
{
    public function safeUp()
    {
        // Add columns
        $this->addColumn('{{%profile}}', 'firstname', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'salutation', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'profession', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'address', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'city', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'zipcode', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'phone', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'fax', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'workplace_type', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'workplace_name', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'profession_number', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'subscribed_to_newsletter', Schema::TYPE_BOOLEAN.' UNSIGNED NOT NULL DEFAULT \'0\'');
        $this->addColumn('{{%profile}}', 'created_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL');
        $this->addColumn('{{%profile}}', 'updated_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL');
    }
    
    public function safeDown()
    {
        // Drop columns
        $this->dropColumn('{{%profile}}', 'firstname');
        $this->dropColumn('{{%profile}}', 'salutation');
        $this->dropColumn('{{%profile}}', 'profession');
        $this->dropColumn('{{%profile}}', 'address');
        $this->dropColumn('{{%profile}}', 'city');
        $this->dropColumn('{{%profile}}', 'zipcode');
        $this->dropColumn('{{%profile}}', 'phone');
        $this->dropColumn('{{%profile}}', 'fax');
        $this->dropColumn('{{%profile}}', 'workplace_type');
        $this->dropColumn('{{%profile}}', 'workplace_name');
        $this->dropColumn('{{%profile}}', 'profession_number');
        $this->dropColumn('{{%profile}}', 'subscribed_to_newsletter');
        $this->dropColumn('{{%profile}}', 'created_at');
        $this->dropColumn('{{%profile}}', 'updated_at');
    }
}
