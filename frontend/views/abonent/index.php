 <?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $SearchForm frontend\models\SearchForm */
/* @var $abonents[] frontend\model\Abonent */
/* @var $groups[] frontend\model\Group */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JqueryAsset;


$this->title = Yii::t('abonent/index', 'Phone Book');
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
                <span class="small glyphicon glyphicon-th-list"></span>&nbsp;<?= Yii::t('abonent/index', 'Groups');?>
            </h3>
            <h6><span class="glyphicon glyphicon-cog"></span>&nbsp;<a href="/group/"><?= Yii::t('abonent/index', 'manage groups');?></a></h6>
            <table class="table table-condensed">
                    <tr>
                        <td><a href="/abonent/index"><?= Yii::t('abonent/index', 'all contacts');?>...</a></td>
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

                <h3><span class="glyphicon glyphicon-user"></span>&nbsp;<?= Yii::t('abonent/index', 'Contacts');?>   
                 <?= Yii::t('abonent/index', Html::a('<span class="glyphicon glyphicon-plus"></span>&nbsp;' . Yii::t('abonent/index', 'Add contact'), ['create'], ['class' => 'btn btn-primary']) ); ?>
                </h3>
                
                <form class="form form-inline form-group">
                    <input class="form-control" type="text" name = "fullname"  placeholder="<?= Yii::t('abonent/index', 'type to search');?>" id="keyword">
                    <a class="btn btn-default" id="search-id"><span class="glyphicon glyphicon-search"></span></a>
                    <p class="text-danger" id="error-id"></p>
                </form>
                   

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        //'user_id',
                        //'group_id',
                        [
                            'format' => 'html',
                            'value' => function($data) {
                                return Html::img($data->getPhoto(),[
                                    'width' => '50px',
                                ]);
                            }
                        ],
                        'name',
                        'patronymic',
                        'surname',
                        'phone',
                        [
                            'attribute' => 'group',
                            'label' => Yii::t('abonent/model', 'Group'),
                            'format' => 'html',
                            'value' => function($ab) {
                                return ($ab->getGroupTitle()) ? $ab->getGroupTitle() : Yii::t('abonent/model','no group');
                            }
                        ],
                        //'photo',
                        'birthdate',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>

    </div>
</div>

<?php $this->registerJsFile('@web/js/clickSearch.js', [
    'depends' => JqueryAsset::className(),
]); ?>
