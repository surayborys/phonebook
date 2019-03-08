<?php

namespace frontend\models;

use Yii;
use frontend\models\Abonent;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 *
 * @property User $user
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbonents()
    {
        return $this->hasMany(Abonent::className(), ['group_id'=>'id'])->all();
    }
    
    public function countAbonents(){
        return count($this->abonents);
    }
}
