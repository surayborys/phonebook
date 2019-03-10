<?php

use yii\db\Migration;
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
        $user = new User([
            
            'name' => 'admin',
            'patronymic' => 'asdasd',
            'surname' => 'lknl',
            'phone' => '380(48)424-44-34',
            'password_hash' => '$2y$13$rirEXiQXjKaEVbwEbEM2H.Vkm2H1f8aBcRwGrDSDZCEG9cGVzxVm.', //111111
            'status' => 10,
            'role_id' => 1,
        ]);
        $user->generateAuthKey();
        $user->save();
        // Assign admin role to 
        $auth->assign($adminRole, $user->getId());
    }
    public function safeDown()
    {
        echo "m171015_143334_create_rbac_data cannot be reverted.\n";
        return false;
    }
}