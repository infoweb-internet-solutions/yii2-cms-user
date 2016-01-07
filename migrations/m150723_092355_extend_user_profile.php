<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_092355_extend_user_profile extends Migration
{
    public function safeUp()
    {
        // Get the column names of the current profile table
        $columnNames = $this->db->schema->getTableSchema('profile', true)->getColumnNames();
        $newColumns = ['firstname', 'address', 'city', 'zipcode', 'phone', 'mobile', 'fax', 'language'];
        
        // Drop any of the new columns if they exist yet
        foreach ($newColumns as $newColumn) {
            if (in_array($newColumn, $columnNames))
                $this->dropColumn('{{%profile}}', $newColumn);
        }
        
        // Add new columns
        $this->addColumn('{{%profile}}', 'firstname', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'address', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'city', Schema::TYPE_STRING.'(255) NOT NULL');
        $this->addColumn('{{%profile}}', 'zipcode', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'phone', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'mobile', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'fax', Schema::TYPE_STRING.'(25) NOT NULL');
        $this->addColumn('{{%profile}}', 'language', Schema::TYPE_STRING.'(10) NOT NULL');
        $this->addColumn('{{%profile}}', 'created_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL');
        $this->addColumn('{{%profile}}', 'updated_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL');   
    }

    public function safeDown()
    {
        return false;    
    }
}
