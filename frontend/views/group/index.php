<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'user_id',
            [
                'attribute' => '',
                'format' => 'html',
                'value' => function($group){
                    return  '<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' 
                    . Html::a('add contacts', ['group/addcontacts', 'id'=>$group->id]);
                }
            ],
            [
                'attribute' => '',
                'format' => 'html',
                'value' => function($group){
                    return  '<span class="glyphicon glyphicon-minus"></span>&nbsp;&nbsp;' 
                    . Html::a('remove contacts', ['group/removecontacts', 'id'=>$group->id]);
                }
            ],       
            [
                'attribute' => 'contacts',
                'format' => 'html',
                'value' => function($group){
                    return  $group->countAbonents();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
