<?php
use yii\widgets\ActiveForm;
?>

<h3>Choose profile's image file</h3>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <button class="btn btn-success">Upload</button>

<?php ActiveForm::end() ?>
