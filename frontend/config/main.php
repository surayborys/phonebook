<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'bootstrap' => [
       'log',
            [
                'class' => 'frontend\components\LanguageSelector',
            ],
        ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'formatter' => [
            'class' => '\frontend\components\PhoneFormatter',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'user/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'abonent/index',
                '/abonent/index/<group_id:\w+>' => 'abonent/index',
                '/abonent/search/<keyword:\w+>' => 'abonent/search',
                '/group/addcontacts/<id:\w+>' => 'group/addcontacts',
                '/group/removecontacts/<id:\w+>' => 'group/removecontacts',
            ],
        ],
        'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'fileMap' => [
                    'abonent/index'  => 'abonent/index.php',
                    'abonent/model' => 'abonent/model.php',
                    'layout/main' => 'layout/main.php',
                ],
            ],
        ],
    ],
    ],
    'params' => $params,
];
