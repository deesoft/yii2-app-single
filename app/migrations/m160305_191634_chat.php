<?php

use yii\db\Migration;
use yii\db\Schema;

class m160305_191634_chat extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%chat}}', [
            'time' => Schema::TYPE_FLOAT,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT,
            'PRIMARY KEY ([[time]])'
            ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%chat}}');
    }
}
