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
    'bootstrap' => ['log'],
    'sourceLanguage'=>'kr',
    'language' => 'kr',
    'timeZone' => 'Asia/Tashkent',
    'name' => 'AgroBuy',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
            'translations' => [
                'class' => 'common\modules\translations\modules\admin\Module'
            ]
    ],
    'components' => [
        'request' => [
            'baseUrl'=>'',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                 'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'=>'{{%source_message}}',
                    'messageTable'=>'{{%message}}',
                    'sourceLanguage' => 'kr',
                    'forceTranslation' => true,
                ],
            ],
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableLanguageDetection' => false,
            'enableDefaultLanguageUrlCode' => true,
            'rules' => [
                '/' => 'site/index',
                'profile/catalog/<login:[\w-]+>' => 'profile/catalog',
                'courses/view/<slug:[\w-]+>' => 'courses/view',
                'podcasts/view/<slug:[\w-]+>' => 'podcasts/view',
                'videos/view/<slug:[\w-]+>' => 'video/view',
                'webinars/view/<slug:[\w-]+>' => 'webinars/view',
                'news/view/<slug:[\w-]+>' => 'news/view',
                'wentrepreneur/view/<slug:[\w-]+>' => 'wentrepreneur/view',

            ],
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['af','en', 'ar', 'az', 'be', 'bg', 'bs', 'cs', 'da', 'de', 'el', 'es', 'et', 'fa', 'fi', 'fr', 'he', 'hr', 'hu', 'hy', 'id', 'it', 'ja', 'ka', 'kk', 'ko', 'kz',  'lv', 'ms', 'nb-NO', 'nl', 'pl', 'pt', 'pt-BR', 'ro', 'ru', 'sk', 'sl', 'sr', 'sr-Latn', 'sv', 'tg', 'th', 'tr', 'uk', 'uz', 'vi', 'zh-CN', 'zh-TW','kr'],
            'on languageChanged' => '\common\models\PreferenceBooks::onLanguageChanged',
        ],
        
    ],
    'params' => $params,
];
 
