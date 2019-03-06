<?php

use yii\db\Migration;
/**
 * Handles the creation of table `{{%abonent}}`.
 */
class m190306_182420_create_abonent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%abonent}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'group_id' => $this->integer(),
            'name' => $this->string(),
            'patronymic' => $this->string(),
            'surname' => $this->string(),
            'phone' => $this->integer(),
            'photo' => $this->string(),
            'birthdate' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%abonent}}');
    }
}
