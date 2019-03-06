<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190306_181340_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'patronymic' => $this->string(),
            'surname' => $this->string(),
            'phone' => $this->integer(),
            'password_hash' => $this->string(),
            'password_reset_token' => $this->string(),
            'photo' => $this->string(),
            'birthdate' => $this->date(),
            'status' => $this->smallInteger(6),
            'role_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
