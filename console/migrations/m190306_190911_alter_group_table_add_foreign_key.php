<?php

use yii\db\Migration;

/**
 * Class m190306_190911_alter_group_table_add_foreign_key
 */
class m190306_190911_alter_group_table_add_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-group-user_id', '{{%group}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-group-user_id', '{{%group}}');
    }
}
