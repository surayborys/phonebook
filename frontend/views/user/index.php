<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $abonents[] frontend\model\Abonent */
/* @var $groups[] frontend\model\Group */
use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'Phone Book';
?>
<div class="site-index">

    <!--div class="jumbotron">
        <h1>Welcome to your phone book</h1> 

        <p class="lead">Register to create your profile or click GO if you've already been registered.</p>

        <p><a class="btn btn-lg btn-success" href="#">GO!</a></p>
    </div-->

    <div class="body-content">

        <div class="col-md-3">
            <table class="table table-condensed">
                <?php foreach ($groups aS $group): ?>
                    <tr>
                        <td><?= $group->title ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="col-md-9">
            <div class="abonent-index">

                <h1><?= Html::encode($this->title) ?></h1>

                <p>
                    <?= Html::a('Abonent', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'user_id',
                        'group_id',
                        'name',
                        'patronymic',
                        //'surname',
                        //'phone',
                        //'photo',
                        //'birthdate',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>

    </div>
</div>
