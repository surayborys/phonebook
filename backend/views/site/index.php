<?php
use yii\helpers\Url;
use backend\models\User;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <h1>Admin panel</h1>
    <hr>
    
    <h3>USERS</h3>
    <ul>
        <li>create, update, delete users</li>
        <li>view user's profiles </li>
        <li>set user status to active/non_active</li>
        <li>manage roles</li>
    </ul>
    
    <?php /*show manage button only for admin users*/?>
    <?php if(!Yii::$app->user->isGuest  && (Yii::$app->user->identity->role_id != User::DEFAULT_USER_ROLE_ID)):?>
    <a href="<?= Url::to('/user/manage')?>" class="btn btn-primary"><span class="glyphicon glyphicon-cog"></span>&nbsp;Manage</a>
    <?php endif; ?>
    
</div>
