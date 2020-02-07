<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use frontend\models\Sessions;
use backend\models\News;

class NewsController extends \yii\web\Controller
{

	public function actionIndex()
    {
    	$session = new Sessions();
    	$identity = Yii::$app->user->identity;

        return $this->render('index',[
        	'identity' => $identity,
            'history' => $history,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionView($id)
    {
    	$news = News::findOne($id);
    	$identity = Yii::$app->user->identity;

        return $this->render('view',[
        	'identity' => $identity,
            'news' => $news,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }
}