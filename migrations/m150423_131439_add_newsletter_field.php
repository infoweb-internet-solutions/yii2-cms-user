<?php

use yii\db\Schema;
use yii\db\Migration;

class m150423_131439_add_newsletter_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'newsletter', Schema::TYPE_BOOLEAN.' UNSIGNED NOT NULL DEFAULT \'0\'');
    }

    public function down()
    {
        $this->dropColumn('{{%profile}}', 'newsletter');
    }
}
