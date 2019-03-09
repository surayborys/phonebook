<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\user */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
        <?php $id = Yii::$app->user->id;?>
    
        <?= $form->field($model, 'id')->hiddenInput(['value'=> $id])->label(false) ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            
        <?= $form->field($model, 'patronymic')->textInput() ?>

        <?= $form->field($model, 'surname')->textInput() ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '380(99)999-99-99',
        ]) ?>
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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
