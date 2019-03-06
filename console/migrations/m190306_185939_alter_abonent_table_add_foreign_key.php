<?php

use yii\db\Migration;

/**
 * add foreihn key to the {{%abonent}} table
 */
class m190306_185939_alter_abonent_table_add_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-abonent-user_id', '{{%abonent}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-abonent-user_id', '{{%abonent}}');
    }
}
