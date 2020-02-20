<?php

namespace api\modules\merchant\controllers;

use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['names', 'user-agent','task', 'proxy', 'surnames', 'logs', 'auto-regs'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}
