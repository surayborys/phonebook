<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php/*determine logged-in user's role*/?>
    <?php $role = Yii::$app->user->identity->role_id?>
    
    <?php /*restrict to update admin and moderators. only admin has permission to this action*/?>
    <?php if(($model->role_id == $model::USER_ADMIN_ROLE_ID || $model->role_id == $model::USER_MODERATOR_ROLE_ID) && ($role != $model::USER_ADMIN_ROLE_ID)):?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

        <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

        <?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

        <?= $form->field($model, 'role_id')->textInput(['maxlength' => true, 'readonly'=> true]) ?>
    
    <?php endif;?>
      
    <?php /*another users of admin panel have permission to update non-admin users */?>
    <?php /*admin has permission to update all users */?>
    <?php if(($model->role_id != $model::USER_ADMIN_ROLE_ID && $model->role_id != $model::USER_MODERATOR_ROLE_ID) || $role == $model::USER_ADMIN_ROLE_ID): ?>
    
        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            
        <?= $form->field($model, 'patronymic')->textInput() ?>

        <?= $form->field($model, 'surname')->textInput() ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '380(99)999-99-99',
        ]) ?>
    
        <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'ACTIVE', $model::STATUS_NON_ACTIVE => 'NON ACTIVE']) ?>
        
        <?php /*only admin has permission to set roles*/?>
        <?php if($role == $model::USER_ADMIN_ROLE_ID):?>
        <?= $form->field($model, 'role_id')->dropDownList([
                $model::USER_ADMIN_ROLE_ID => 'ADMIN',
                $model::USER_MODERATOR_ROLE_ID => 'MODERATOR',
                $model::DEFAULT_USER_ROLE_ID => 'DEFAULT USER'
            ]) ?>
        <?php endif;?>
    
        <?php /*= $form->field($model, 'birthdate')->widget(
                    DatePicker::className(), [
                        // inline too, not bad
                        'inline' => true,
                        // modify template for custom rendering
                        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
        ]); */?>

        
    <?php endif;?>
    
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
