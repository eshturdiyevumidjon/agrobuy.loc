<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' =>'ru-RU',
    'name' => 'Agrobuy.uz',
    'timeZone' =>'Asia/Tashkent',
    'defaultRoute' =>'ads',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'translations' => [
            'class' => 'common\modules\translations\modules\admin\Module'
        ]
    ],
    'components' => [

        'i18n' => [
                'translations' => [
                    'app*' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@backend/messages',
                        //'sourceLanguage' => 'en-US',
                        'fileMap' => [
                            'app'       => 'app.php',
                            'app/error' => 'error.php',
                        ],
                    ],
                ],
            ],

         'mailer' => [
            // 'viewPath' => '@common/mail', 
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'mchacker3033@gmail.com',
                'password' => '23249798',
                'port' => '465',
                'encryption' => 'ssl',
                'streamOptions' => [ 
                    'ssl' => [ 
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[],
                ],
                  
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
            
        ],
         'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
            ],
            // 'class' => 'codemix\localeurls\UrlManager',
            // 'languages' => ['kr','uz', 'ru'],
            // 'on languageChanged' => '\common\models\PreferenceBooks::onLanguageChanged',
        ],
        
    ],
    'params' => $params,
];
