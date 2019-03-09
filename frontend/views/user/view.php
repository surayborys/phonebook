<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\user */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
    <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'patronymic',
            'surname',
            'phone',
            //'password_hash',
            //'password_reset_token',
            //'photo',
            //'birthdate',
        //'status',
        //'role_id',
        //'auth_key',
        ],
    ])
    ?>

</div>
