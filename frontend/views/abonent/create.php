<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Abonent */

$this->title = 'Create Abonent';
?>
<div class="abonent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
