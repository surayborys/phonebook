<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php    
    
    $en_ikon = \powerkernel\flagiconcss\Flag::widget([
	    'tag' => 'span', // flag tag
		'country' => 'us', // where xx is the ISO 3166-1-alpha-2 code of a country,
		'squared' => false, // set to true if you want to have a squared version flag
		'options' => [] // tag html options
	]); 
    
    $uk_ikon = \powerkernel\flagiconcss\Flag::widget([
	    'tag' => 'span', // flag tag
		'country' => 'ua', // where xx is the ISO 3166-1-alpha-2 code of a country,
		'squared' => false, // set to true if you want to have a squared version flag
		'options' => [] // tag html options
	]);
    ?>
    
    <?php /*nav  bar*/
    NavBar::begin([
        'brandLabel' => Yii::t('layout/main', Yii::$app->params['appName']),
        'brandUrl' => Yii::$app->params['appUrl'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('layout/main', 'Signup'), 'url' => ['/user/signup']];
        $menuItems[] = ['label' => Yii::t('layout/main','Login'), 'url' => ['/user/login']];
    } else {
        $menuItems[] = ['label' => Yii::t('layout/main','Profile'), 'url' => ['/user/view/']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/logout'], 'post')
            . Html::submitButton(
                '<span class="glyphicon glyphicon-off"></span>&nbsp;' .
                Yii::t('layout/main', 'Logout') . '&nbsp;(' . Yii::$app->user->identity->name . ')',
                    ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    
    if(Yii::$app->language == 'uk-UA') {
        $menuItems[] = '<li class="nav-item">' . '<a href="/user/language?language=en-US">' . 'English ' . $en_ikon . '</a>' . '</li>';
    }
    if(Yii::$app->language == 'en-US') {
        $menuItems[] = '<li class="nav-item">' . '<a href="/user/language?language=uk-UA">' . 'Українська ' . $uk_ikon . '</a>' . '</li>';
    }
        
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,  
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
    
</body>
</html>
<?php $this->endPage() ?>
