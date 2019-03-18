<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Abonent */

$this->title = 'Update Abonent: ' . $model->name;
?>
<div class="abonent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
