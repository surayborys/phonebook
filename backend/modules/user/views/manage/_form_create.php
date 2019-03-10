<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php/*determine logged-in user's role*/?>
    <?php $role = Yii::$app->user->identity->role_id?>

    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            
    <?= $form->field($model, 'patronymic')->textInput() ?>

    <?= $form->field($model, 'surname')->textInput() ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
        'mask' => '380(99)999-99-99',
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?php /*only admin has permission to set roles*/?>
    <?php if($role == User::USER_ADMIN_ROLE_ID):?>
    <?= $form->field($model, 'role_id')->dropDownList([
        User::USER_ADMIN_ROLE_ID => 'ADMIN',
        User::USER_MODERATOR_ROLE_ID => 'MODERATOR',
        User::DEFAULT_USER_ROLE_ID => 'DEFAULT USER'
            ]) ?>
    <?php endif;?>
    
    <?php /*non-admin user's of admin panel has permission to create only default user*/?>
    <?php if($role != User::USER_ADMIN_ROLE_ID):?>
    <?= $form->field($model, 'role_id')->hiddenInput(['value'=>User::DEFAULT_USER_ROLE_ID]) ?>
    <?php endif;?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
