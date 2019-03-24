<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Abonent */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="abonent-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <img src="<?= $model->getPhoto()?>" alt="abonent-photo" style="width: 100px">
    <hr>
    
    <p>
        <?= Html::a('Remove photo', ['remove-photo', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <hr>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'user_id',
            //'group_id',
            [
                'attribute' => 'group',
                'format' => 'html',
                'value' => function($ab) {
                    return ($ab->getGroupTitle()) ? $ab->getGroupTitle() : 'no group';
                }
            ],
            'name',
            'patronymic',
            'surname',
            [
                'attribute'=>'phone',
                'format' => 'html',
                'value'=>function($ab){
                    return Yii::$app->formatter->asPhone($ab->phone);
                }
            ],
            //'photo',
            'birthdate',
        ],
    ]) ?>

</div>
