<?php

namespace frontend\models;

use Yii;
use frontend\models\Group;
use yii\helpers\FileHelper;

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
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abonent';
    }
    
    //use events
    public function __construct() {
        //execute the savePhoto() method after inserting/updating of model
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'savePhoto']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'savePhoto']);
        //execute the unmaskPhone() method before inserting/updating of model
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'unmaskPhone']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'unmaskPhone']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'integer'],
            [['phone', 'name'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
            'name' => Yii::t('abonent/model', 'Name'),
            'patronymic' => Yii::t('abonent/model', 'Patronymic'),
            'surname' => Yii::t('abonent/model', 'Surname'),
            'phone' => Yii::t('abonent/model', 'Phone'),
            'photo' => Yii::t('abonent/model', 'Photo'),
            'birthdate' => Yii::t('abonent/model', 'Birthdate'),    
        ];
    }
    
    /**
     * uploads photo and assigns 'photo' attribute's value to the model
     * 
     * @return boolean
     */
    public function savePhoto(){
        if($this->imageFile  && $this->photo = $this->upload($this->user_id, $this->getPrimaryKey())) {
            //off the events to avoid infinite loop
            $this->off(self::EVENT_AFTER_INSERT, [$this, 'savePhoto']);
            $this->off(self::EVENT_AFTER_UPDATE, [$this, 'savePhoto']);
            
            return $this->save(false);
        } 
        return true;
    }
    
    /**
     * takes off the input mask
     * 
     * uses the frontend\components\PhoneFormatter as custom extention of Yii::$app->formatter
     * @return string
     */
    public function unmaskPhone(){
        
        $this->phone = Yii::$app->formatter->asUnmaskedNumber($this->phone);
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     *  sets fullname property for the user
     */
    public function setFullName() {
        $this->fullname = $this->name . ' ' . $this->surname . ' ' . $this->phone;
    }
    
    /**
     * gets group title from the {{%group}} table by group_id
     * 
     * @return boolean|string
     */
    public function getGroupTitle() {
        if(isset($this->group_id) && !empty($this->group_id)) {
            $group = Group::findOne(['id' => $this->group_id]);
            $title = $group->title;
            return $title;
        }
        return false;
    }
    
    /**
     * checks if the user has photo and returns path to photo or path to default profile image
     * 
     * @return string
     */
    public function getPhoto() {
        if(isset($this->photo) && !empty($this->photo)) {
            return Yii::getAlias('@web'). '/' . $this->photo;
        }
        return Yii::$app->params['defaultProfileImage'];
    }
    
    /**
     * uploads image with specific name
     * 
     * @param int $user_id
     * @param int $abonent_id
     * @return boolean|string
     */
    public function upload($user_id, $abonent_id)
    {
        $prePath = $this->preparePath($user_id, $abonent_id);
        $fullPath = $prePath . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->imageFile->saveAs($fullPath);
        return $fullPath;
    }
    
    /**
     * returns path to file like uploads/users/{$user_id}/members/{$abonent_id}
     * and creates required folders if they don't exist
     * 
     * @param type $user_id
     * @param type $abonent_id
     * @return string
     */
    protected function preparePath($user_id, $abonent_id) {
        
        $path = 'uploads/users/' . $user_id . '/members/' . $abonent_id . '/';
        if(!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        return $path;
    }
}
