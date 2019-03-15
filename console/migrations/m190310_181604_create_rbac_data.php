<?php

use yii\db\Migration;
use backend\models\SignupForm;
use backend\models\User;

/**
 * Class m190310_181604_create_rbac_data
 */
class m190310_181604_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;    
        // Define permissions
        
        // Define roles with permissions
        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);
        
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        
        // Create admin user
        // After creating admin create new admin user with secure password and delete or change role for this user     
        $model = new SignupForm();
        $model->name = 'admin';
        $model->patronymic = 'asdasd';
        $model->surname = 'lknl';
        $model->phone = '380(48)424-44-34';
        $model->password = '111111';
        $model->role_id = User::USER_ADMIN_ROLE_ID; //admin role_id

        if(!$model->save()){
            return false;
        }            
    }
    public function safeDown()
    {
        echo "m171015_143334_create_rbac_data cannot be reverted.\n";
        return false;
    }
}