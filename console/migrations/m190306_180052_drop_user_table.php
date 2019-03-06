<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%user}}`.
 */
class m190306_180052_drop_user_table extends Migration
{
    /**
     * Drops default user table
     */
    public function safeUp()
    {
        $this->dropTable('{{%user}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
