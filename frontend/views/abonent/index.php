<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $abonents[] frontend\model\Abonent */
/* @var $groups[] frontend\model\Group */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use kartik\date\DatePicker;


$this->title = Yii::t('abonent/index', 'Phone Book');
?>
<div class="site-index">

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

                <h2><span class="glyphicon glyphicon-user"></span>&nbsp;<?= Yii::t('abonent/index', 'Contacts');?>   
                 <?= Yii::t('abonent/index', Html::a('<span class="glyphicon glyphicon-plus"></span>&nbsp;' . Yii::t('abonent/index', 'Add contact'), ['create'], ['class' => 'btn btn-primary']) ); ?>
                </h2>
                               
                <form class="form form-inline form-group">
                    <fieldset class="form-group">
                        <hr>
                        <p>
                            <span class="glyphicon glyphicon-filter"></span><?= Yii::t('abonent/index', 'Filter')?>
                            <a class="btn btn-default btn-sm" id="filter-id">
                                <span class="glyphicon glyphicon-ok"></span>
                                <?= Yii::t('abonent/index', 'use filter')?>
                            </a>
                            <a class="btn btn-default btn-sm" href="/">
                                <span class="glyphicon glyphicon-remove"></span>
                                <?= Yii::t('abonent/index', 'cancel filter')?>
                            </a>
                        </p>
                          <div class="form-group row">
                            <input class="form-control" type="text" name = "fullname"  placeholder="<?= Yii::t('abonent/index', 'name');?>" id="f_name">
                            <input class="form-control" type="text" name = "phone"  placeholder="<?= Yii::t('abonent/index', 'phone');?>" id="f_phone">
                            <!--input class="form-control" type="text" name = "birthdate"  placeholder="<?//= Yii::t('abonent/index', 'date');?>" id="f_date"-->
                            <?= DatePicker::widget([
                                'name' => 'birthdate',
                                'id'=>"f_date",
                                'value' => '',
                                'options' => ['placeholder' => Yii::t('abonent/index', 'birthdate')],
                                'pluginOptions' => [
                                        'autoclose' => true,
                                        'viewMode' => "days",
                                        'format' => 'yyyy-mm-dd'
                                ]
        ]);                 ?>
                            <input class="form-control" type="text" name = "group"  placeholder="<?= Yii::t('abonent/index', 'group');?>" id="f_group">
                          </div>
                        </fieldset>
                    <p class="text-danger" id="filter-error-id"></p>
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
                        [
                            'attribute'=>'phone',
                            'format' => 'html',
                            'value'=>function($ab){
                                return Yii::$app->formatter->asPhone($ab->phone);
                            }
                        ],
                        [
                            'attribute' => 'group',
                            'label' => Yii::t('abonent/model', 'Group'),
                            'format' => 'html',
                            'value' => function($ab) {
                                return ($ab->getGroupTitle()) ? $ab->getGroupTitle() : Yii::t('abonent/model','no group');
                            }
                        ],
                        //'photo',
                        [
                            'attribute'=>'birthdate',
                            'format' => 'html',
                            'value'=>function($ab){
                                return Yii::$app->formatter->asDate($ab->birthdate, 'long');
                            }
                        ],
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

<?php $this->registerJsFile('@web/js/clickFilter.js', [
    'depends' => JqueryAsset::className(),
]); ?>
