<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "abonent".
 *
 * @property int $id
 * @property int $user_id
 * @property int $group_id
 * @property string $name
 * @property string $patronymic
 * @property string $surname
 * @property string $phone
 * @property string $photo
 * @property string $birthdate
 *
 * @property User $user
 */
class Abonent extends \yii\db\ActiveRecord
{
    public $fullname;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abonent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'integer'],
            [['phone', 'name'], 'required'],
            [['birthdate'], 'date', 'format' => 'php:Y-m-d'],
            [['name', 'patronymic', 'surname', 'photo'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
            'name' => 'Name',
            'patronymic' => 'Patronymic',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'photo' => 'Photo',
            'birthdate' => 'Birthdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function setFullName() {
        $this->fullname = $this->name . ' ' . $this->surname . ' ' . $this->phone;
    }
}
