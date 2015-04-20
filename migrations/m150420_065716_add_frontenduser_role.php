<?php

use yii\db\Schema;
use yii\db\Migration;

class m150420_065716_add_frontenduser_role extends Migration
{
    public function up()
    {
        // Create the auth items
        $this->insert('{{%auth_item}}', [
            'name'          => 'frontendUser',
            'type'          => 1,
            'description'   => 'Frontend User',
            'created_at'    => time(),
            'updated_at'    => time()
        ]);    
    }
    
    public function down()
    {
        $this->delete('{{%auth_item}}', ['name' => 'frontendUser']);    
    }
}
