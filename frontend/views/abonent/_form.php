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

    <?php $form = ActiveForm::begin(); ?>

    <!--user_id input field is hidden-->
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=> $curUserId])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::findAll(['user_id'=>$curUserId]),'id', 'title'), ['prompt' => '--no group--'])->label('Group') ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                    'mask' => '380(99)999-99-99',
                ]) ?>

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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
