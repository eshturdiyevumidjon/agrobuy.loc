<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use frontend\models\Sessions;
use backend\models\News;
use backend\models\NewsSearch;
use backend\models\AdvertisingItems;
use backend\models\NewsSlider;
use backend\models\NewsSort;
use yii\web\NotFoundHttpException;

class NewsController extends \yii\web\Controller
{

	public function actionIndex()
    {
        $session = new Sessions();
        $adv = $session->getMainNews();
    	$searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 20,];

        $reklama = AdvertisingItems::find()
            ->joinWith('advertising')
            ->where(['advertising_id' => $adv->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();
        foreach ($reklama as $value) {
            $value->view_count = $value->view_count + 1;
            $value->save();
        }

        return $this->render('index',[
            'reklama' => $reklama,
        	'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionView($id)
    {
    	$news = $this->findModel($id);
    	$identity = Yii::$app->user->identity;

        $slider = NewsSlider::find()->where(['news_id' => $id])->all();
        $sort = NewsSort::find()->where(['news_id' => $id])->all();

        return $this->render('view',[
            'sort' => $sort,
            'slider' => $slider,
        	'identity' => $identity,
            'model' => $news->getOneModel(),
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}