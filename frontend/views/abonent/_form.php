<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use frontend\models\Group;

/* @var $this yii\web\View */
/* @var $model frontend\models\Abonent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abonent-form">
    
    <?php $curUserId = Yii::$app->user->id;?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-md-8">
    <!--user_id input field is hidden-->
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=> $curUserId])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::findAll(['user_id'=>$curUserId]),'id', 'title'), ['prompt' => '--no group--'])->label('Group') ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                    'mask' => '380(99)999-99-99',
                ]) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <div class="col-md-4">
    <?php /*assign $button_action to 'select' for selecting profile image action*/ ?>
    <?php $button_action = 'select'?>
        
    <?php /*show user photo only if it exists */?>    
    <?php if(isset($model->photo)):?>
        <img src="<?= $model->getPhoto()?>" alt="abonent-photo" style="width: 80px" alt="profile photo">
            <?php /*assign $button_action to 'change' for changing profile image action*/ ?>
            <?php $button_action = 'change'?>
    <?php endif;?>
    <p><b>Photo</b></p>   
    <div class="file-input btn btn-primary">
        
        <span class="glyphicon glyphicon-user"></span> <?= $button_action?>&nbsp;profile image
              
    <?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>
    </div>              
    <?= $form->field($model, 'birthdate')->widget(
                    DatePicker::className(), [
                        // inline too, not bad
                        'inline' => true,
                        // modify template for custom rendering
                        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
    </div>
        
    <?php ActiveForm::end(); ?>

</div>
