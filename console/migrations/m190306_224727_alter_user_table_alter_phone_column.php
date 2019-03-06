<?php

use yii\db\Migration;

/**
 * Class m190306_224727_alter_user_table_alter_phone_column
 */
class m190306_224727_alter_user_table_alter_phone_column extends Migration
{
    /**
     * change user.phone column's data type to string
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'phone', $this->integer());
    }
}
