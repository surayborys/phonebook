<?php

use yii\db\Migration;

/**
 * Class m190307_230025_alter_abonent_table_alter_phone_column
 */
class m190307_230025_alter_abonent_table_alter_phone_column extends Migration
{
   /**
     * change user.phone column's data type to string
     */
    public function safeUp()
    {
        $this->alterColumn('{{%abonent}}', 'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%abonent}}', 'phone', $this->integer());
    }
}
