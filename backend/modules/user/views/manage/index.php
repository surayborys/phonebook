<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'patronymic',
            'surname',
            'phone',
            //'password_hash',
            //'password_reset_token',
            //'photo',
            //'birthdate',
            'status',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($ab) {
                    switch ($ab->status){
                        case User::STATUS_ACTIVE :
                            return 'ACTIVE';
                        case User::STATUS_NON_ACTIVE:
                            return 'NON ACTIVE';
                        default :
                            break;
                    }
                }
            ],
            'role_id',
            [
                'attribute' => 'role_id',
                'format' => 'html',
                'value' => function($ab) {
                    switch ($ab->role_id){
                        case User::USER_ADMIN_ROLE_ID :
                            return 'ADMIN';
                        case User::USER_MODERATOR_ROLE_ID:
                            return 'MODERATOR';
                        case User::DEFAULT_USER_ROLE_ID:
                            return 'USER';
                        default :
                            break;
                    }
                }
            ],
            //'auth_key',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
