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

        <div class="col-md-2">
            <h3>
                <span class="small glyphicon glyphicon-th-list"></span>&nbsp;Groups
            </h3>
            <h6><span class="glyphicon glyphicon-cog"></span>&nbsp;<a href="/group/">manage groups</a></h6>
            <table class="table table-condensed">
                    <tr>
                        <td><a href="/abonent/index">all contacts...</a></td>
                    </tr>
                <?php foreach ($groups aS $group): ?>
                    <tr>
                        <td><a href="/abonent/index/<?=$group->id?>"><?= $group->title ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="col-md-10">
            <div class="abonent-index">

                <h3><span class="glyphicon glyphicon-user"></span>&nbsp;Contacts</h3>

                <p>
                    <?= Html::a('Add new contact', ['create'], ['class' => 'btn btn-default']) ?>
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
                        'surname',
                        'phone',
                        'photo',
                        'birthdate',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>

    </div>
</div>
