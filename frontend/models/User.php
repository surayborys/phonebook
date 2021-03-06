<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use frontend\models\Group;
use frontend\models\Abonent;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $patronymic
 * @property string $surname
 * @property integer $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $photo
 * @property string $birthdate
 * @property string $auth_key
 * @property integer $status
 * @property integer role_id
 * @property string $password write-only 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NON_ACTIVE = 0;
    const STATUS_ACTIVE = 10;
    
    const DEFAULT_USER_ROLE_ID = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NON_ACTIVE]],
            
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            
            ['patronymic', 'trim'],
            ['patronymic', 'required'],
            ['patronymic', 'string', 'min' => 2, 'max' => 255],
            
            ['surname', 'trim'],
            ['surname', 'required'],
            ['surname', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'min' => 16, 'max' =>16],
            ['phone', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This phone number has already been taken.'],
            
            ['birthdate', 'date', 'format' => 'php:Y-m-d'],
            
            ['role_id', 'required'],
            ['role_id', 'safe'],
            ['role_id', 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by phone number
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * get linked data for the User $this in the 'abonent' table
     * <p>User has many abonents (frontend\models\Abonent) </p>
     * 
     * @return array[] frontend\models\Abonent
     */
    public function getAbonents()
    {
        $order = ['id' => SORT_DESC];
        return $this->hasMany(Abonent::className(), ['user_id' => 'id'])->orderBy($order)->all();
    }
    
    /**
     * get linked data for the User $this in the 'group' table
     * <p>User has many groups (frontend\models\Group) </p>
     * 
     * @return array[] frontend\models\Group
     */
    public function getGroups()
    {
        $order = ['id' => SORT_DESC];
        return $this->hasMany(Group::className(), ['user_id' => 'id'])->orderBy($order)->all();
    }
}
