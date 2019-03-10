<?php
namespace backend\models;

use yii\base\Model;
use backend\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $patronymic;
    public $surname;
    public $phone;
    public $password;
    public $role_id;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
                    
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
            ['phone', 'string'],
            ['phone', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This phone number has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['role_id', 'required'],
            ['role_id', 'integer']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->name = $this->name;
        $user->patronymic = $this->patronymic;
        $user->surname = $this->surname;
        $user->phone = $this->phone;
        $user->role_id = $this->role_id;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
